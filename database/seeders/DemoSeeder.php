<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Sample data for LOCAL development only. Every person, ID number, phone
 * number and address here is made up; the emails use the reserved
 * example.com domain.
 *
 *   php artisan migrate:fresh --seed --seeder=DemoSeeder
 *
 * Every account's password is: LocalTest1
 * Never run this against the production database.
 */
class DemoSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->environment('production')) {
            $this->command->error('DemoSeeder refuses to run in production.');
            return;
        }

        $password = Hash::make('LocalTest1');
        $address = fn (int $no) => "No. {$no} Jalan Contoh 1/1, Taman Contoh, 00000 Contoh, Selangor";

        $users = [
            ['000000000001', 'Demo Administrator', '2001-01-01', 'Male', 'admin@example.com', '0100000001', 1, null, 'Leadership', 'Administrator'],
            ['000000000002', 'Demo Coordinator One', '2002-02-02', 'Male', 'coordinator1@example.com', '0100000002', 2, null, 'Time management', 'Event Coordinator'],
            ['000000000003', 'Demo Coordinator Two', '2003-03-03', 'Female', 'coordinator2@example.com', '0100000003', 3, null, 'Problem solving', 'Event Coordinator'],
            ['000000000004', 'Demo Volunteer One', '2004-04-04', 'Male', 'volunteer1@example.com', '0100000004', 4, 'Student', 'Communication', 'Volunteer'],
            ['000000000005', 'Demo Volunteer Two', '2005-05-05', 'Female', 'volunteer2@example.com', '0100000005', 5, 'Designer', 'Teamwork', 'Volunteer'],
        ];
        foreach ($users as [$id, $name, $dob, $gender, $email, $phone, $no, $job, $skills, $role]) {
            DB::table('user_details')->insert([
                'UserID' => $id, 'UserFullName' => $name, 'UserDateOfBirth' => $dob, 'UserGender' => $gender,
                'UserEmail' => $email, 'UserPassword' => $password, 'UserPhoneNumber' => $phone,
                'UserAddress' => $address($no), 'UserOccupation' => $job, 'UserTransport' => 'I have my own vehicle',
                'UserShirtSize' => 'M', 'UserSkillsAndExperiences' => $skills, 'UserRole' => $role,
            ]);
        }

        // Dates are relative to today so "Upcoming" events stay in the future
        $day = fn (int $offset) => now()->addDays($offset)->toDateString();
        $events = [
            [1, 'Guardians Against Garbage Program', 'Guardians Against Garbage Program is a strategic partnership between Coway Malaysia and EcoKnights to raise public awareness and knowledge on the challenges of solid waste management primarily at local level.', -60, 'Sungai Kayu Ara, Petaling Jaya', 'Completed', '000000000002', 1],
            [2, 'Tree For Us Event', 'Tree For Us Event is supported by Epson Malaysia, in partnership with Landscape and Recreation Development Department, Kuala Lumpur City Hall to contribute to the national 100 Million Tree Planting Initiative.', -30, 'Bandar Tasik Selatan, Kuala Lumpur', 'Completed', '000000000003', 1],
            [3, 'Planet Us Exhibition', 'Planet Us Exhibition is an interactive and educational exhibit that will educate and inspire Malaysian youth to play a more proactive role in tackling the climate crisis and in contributing to an environmentally sustainable future.', 26, 'The Square@Publika Shopping Gallery, Kuala Lumpur', 'Upcoming', '000000000002', 2],
            [4, 'Yayasan Sime Darby Art Festival', "Yayasan Sime Darby Art Festival is Malaysia's biggest free-for-all art festival presented by Yayasan Sime Darby and The Kuala Lumpur Performing Arts Centre, featuring performances, workshops, and interactive activities.", 54, 'Kuala Lumpur Performing Arts Centre, Kuala Lumpur', 'Upcoming', '000000000003', 5],
        ];
        foreach ($events as [$id, $name, $desc, $start, $location, $status, $coordinator, $max]) {
            DB::table('event_details')->insert([
                'EventID' => $id, 'EventName' => $name, 'EventDescription' => $desc,
                'EventStartDate' => $day($start), 'EventEndDate' => $day($start + 1),
                'EventLocation' => $location, 'EventStatus' => $status,
                'CoordinatorID' => $coordinator, 'MaxVolunteers' => $max,
            ]);
        }

        $participations = [
            ['000000000004', 1, 'Environmental Volunteer', 'Approved', 'Attended'],
            ['000000000004', 2, 'Environmental Volunteer', 'Approved', 'Attended'],
            ['000000000004', 3, 'Logistics Facilitator', 'Approved', null],
            ['000000000005', 3, 'Booth Assistant', 'Approved', null],   // event 3 is now full
            ['000000000004', 4, 'Workshop Facilitator', 'Approved', null],
            ['000000000005', 4, 'Booth Assistant', 'Pending', null],    // something to approve
        ];
        foreach ($participations as [$volunteer, $event, $role, $approval, $attendance]) {
            DB::table('event_participation')->insert([
                'VolunteerID' => $volunteer, 'EventID' => $event, 'EventRole' => $role,
                'ApprovalStatus' => $approval, 'AttendanceStatus' => $attendance,
            ]);
        }

        DB::table('event_feedback')->insert([
            ['UserID' => '000000000002', 'EventID' => 1, 'EventRating' => '5', 'EventComment' => 'The program was a success. We managed to exceed our waste collection targets by 15%.'],
            ['UserID' => '000000000004', 'EventID' => 2, 'EventRating' => '5', 'EventComment' => 'It was an incredibly rewarding experience, and the tree planting process was smooth and educational.'],
        ]);
    }
}
