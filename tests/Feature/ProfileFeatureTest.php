<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\Country;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ProfileFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        DB::table('roles')->insertOrIgnore([
            'id' => 1,
            'name' => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function test_owner_can_view_edit_form_and_update_profile_details(): void
    {
        $country = Country::query()->create(['name' => 'Bulgaria']);
        $city = City::query()->create(['name' => 'Sofia', 'country_id' => $country->id]);
        $user = User::factory()->create([
            'username' => 'old_name',
            'email' => 'old@example.com',
        ]);

        $this->actingAs($user)
            ->get(route('profile.edit'))
            ->assertOk()
            ->assertSee('Edit profile')
            ->assertSee('old_name');

        $this->actingAs($user)
            ->put(route('profile.update'), [
                'username' => 'new_name',
                'email' => 'new@example.com',
                'first_name' => 'Maya',
                'last_name' => 'Stone',
                'phone' => '+359 888 123 456',
                'date_of_birth' => '1997-05-10',
                'city_id' => $city->id,
                'bio' => 'A fresh profile bio.',
            ])
            ->assertRedirect(route('profile', 'new_name'));

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'username' => 'new_name',
            'email' => 'new@example.com',
            'first_name' => 'Maya',
            'last_name' => 'Stone',
            'phone' => '+359 888 123 456',
            'city_id' => $city->id,
            'bio' => 'A fresh profile bio.',
        ]);
    }

    public function test_profile_shows_real_stats_and_owner_private_details_only_to_owner(): void
    {
        $owner = User::factory()->create([
            'username' => 'profile_owner',
            'email' => 'private@example.com',
            'phone' => '+359 888 000 111',
            'bio' => 'Visible public bio.',
        ]);
        $visitor = User::factory()->create();
        $follower = User::factory()->create();

        DB::table('follows')->insert([
            'following_user_id' => $follower->id,
            'followed_user_id' => $owner->id,
            'status' => 'accepted',
            'created_at' => now(),
        ]);

        DB::table('follows')->insert([
            'following_user_id' => $owner->id,
            'followed_user_id' => $visitor->id,
            'status' => 'accepted',
            'created_at' => now(),
        ]);

        $this->actingAs($owner)
            ->get(route('profile'))
            ->assertOk()
            ->assertSee('Visible public bio.')
            ->assertSee('private@example.com')
            ->assertSee('+359 888 000 111')
            ->assertSee('Edit Profile')
            ->assertSee('1')
            ->assertSee('Followers')
            ->assertSee('Following');

        $this->actingAs($visitor)
            ->get(route('profile', $owner->username))
            ->assertOk()
            ->assertSee('Visible public bio.')
            ->assertSee('Follow')
            ->assertDontSee('private@example.com')
            ->assertDontSee('+359 888 000 111');
    }

    public function test_user_can_follow_and_unfollow_another_profile(): void
    {
        $viewer = User::factory()->create(['username' => 'viewer']);
        $profileUser = User::factory()->create(['username' => 'creator']);

        $this->actingAs($viewer)
            ->post(route('profile.follow', $profileUser->username))
            ->assertRedirect();

        $this->assertDatabaseHas('follows', [
            'following_user_id' => $viewer->id,
            'followed_user_id' => $profileUser->id,
            'status' => 'accepted',
        ]);

        $this->actingAs($viewer)
            ->get(route('profile', $profileUser->username))
            ->assertOk()
            ->assertSee('Following');

        $this->actingAs($viewer)
            ->delete(route('profile.unfollow', $profileUser->username))
            ->assertRedirect();

        $this->assertDatabaseMissing('follows', [
            'following_user_id' => $viewer->id,
            'followed_user_id' => $profileUser->id,
        ]);
    }

    public function test_user_cannot_follow_their_own_profile(): void
    {
        $user = User::factory()->create(['username' => 'self_user']);

        $this->actingAs($user)
            ->post(route('profile.follow', $user->username))
            ->assertUnprocessable();

        $this->assertDatabaseMissing('follows', [
            'following_user_id' => $user->id,
            'followed_user_id' => $user->id,
        ]);
    }
}
