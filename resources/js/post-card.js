export function postCard({ postId, liked, likesCount, commentsCount, initialShowComments = false, allComments = false }) {
    return {
        postId,
        liked,
        likesCount,
        commentsCount,
        showComments: initialShowComments,
        allComments,
        comments: [],
        loaded: false,
        loadingComments: false,
        loadRequestId: 0,
        newComment: '',
        submitting: false,

        async toggleLike() {
            const res = await fetch(`/posts/${this.postId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            });
            if (!res.ok) return;
            const data = await res.json();
            this.liked = data.liked;
            this.likesCount = data.likes_count;
        },

        async loadComments() {
            const requestId = ++this.loadRequestId;
            this.loadingComments = true;

            try {
                const url = `/posts/${this.postId}/comments${this.allComments ? '?all=1' : ''}`;
                const res = await fetch(url, {
                    headers: { 'Accept': 'application/json' },
                });

                if (!res.ok || requestId !== this.loadRequestId) {
                    return;
                }

                const data = await res.json();
                if (requestId !== this.loadRequestId) {
                    return;
                }

                this.comments = data.map((c) => ({ ...c, showReply: false }));
                this.loaded = true;
            } finally {
                if (requestId === this.loadRequestId) {
                    this.loadingComments = false;
                }
            }
        },

        async submitComment() {
            const content = this.newComment.trim();
            if (!content || this.submitting) {
                return;
            }

            this.submitting = true;

            try {
                const res = await fetch(`/posts/${this.postId}/comments`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ content }),
                });

                if (!res.ok) {
                    const err = await res.text();
                    console.error('Comment error:', res.status, err);
                    return;
                }

                const data = await res.json();

                // Ignore any in-flight loadComments() that started before this submit.
                this.loadRequestId++;

                this.comments.unshift({
                    ...data.comment,
                    showReply: false,
                    replies: data.comment.replies ?? [],
                });
                this.commentsCount = data.comments_count;
                this.newComment = '';
                this.loaded = true;
            } catch (error) {
                console.error('Comment request failed:', error);
            } finally {
                this.submitting = false;
            }
        },

        async deleteComment(id) {
            window.dispatchEvent(new CustomEvent('confirm-delete', {
                detail: {
                    title: 'Delete comment',
                    message: 'Are you sure you want to delete this comment?',
                    callback: async () => {
                        const res = await fetch(`/comments/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                            },
                        });

                        if (!res.ok) {
                            return;
                        }

                        const data = await res.json();
                        let removedTopLevel = false;

                        this.comments = this.comments
                            .filter((c) => {
                                if (c.id === id) {
                                    removedTopLevel = true;
                                    return false;
                                }
                                return true;
                            })
                            .map((c) => ({
                                ...c,
                                replies: (c.replies || []).filter((r) => r.id !== id),
                            }));

                        if (typeof data.comments_count === 'number') {
                            this.commentsCount = data.comments_count;
                        } else if (removedTopLevel) {
                            this.commentsCount = Math.max(0, this.commentsCount - 1);
                        }
                    },
                },
            }));
        },

        async deletePost(id) {
            window.dispatchEvent(new CustomEvent('confirm-delete', {
                detail: {
                    title: 'Delete post',
                    message: 'Are you sure? This cannot be undone.',
                    callback: async () => {
                        const res = await fetch(`/posts/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                            },
                        });
                        if (res.ok) {
                            this.$el.remove();
                        }
                    },
                },
            }));
        },

        async toggleCommentLike(commentId) {
            const res = await fetch(`/comments/${commentId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            });
            if (!res.ok) return;
            const data = await res.json();
            this.comments = this.comments.map((c) =>
                c.id === commentId
                    ? { ...c, liked: data.liked, likes_count: data.likes_count }
                    : c
            );
        },

        async submitReply(parentId, content) {
            const text = content?.trim();
            if (!text) {
                return;
            }

            const res = await fetch(`/posts/${this.postId}/comments`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ content: text, parent_id: parentId }),
            });

            if (!res.ok) {
                return;
            }

            const data = await res.json();
            this.comments = this.comments.map((c) =>
                c.id === parentId
                    ? { ...c, replies: [...(c.replies || []), data.comment], showReply: false }
                    : c
            );
        },
    };
}
