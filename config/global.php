<?php
return [
    'rest_api' => env('REST_API', false),
    'court' => [
        'status' => [
            'open' => 'OPEN',
            'closed' => 'CLOSED'
        ],
        'environment' => [
            'Indoor' => 'INDOOR',
            'Outdoor' => 'OUTDOOR'
        ],
        'ballmachinestatus' => [
            0 => 'No',
            1 => 'Yes'
        ]
    ],
    'image_path' => [
        'user_profile_path' => 'uploads/profile/{member_id}/',
        'employee_profile_path' => 'uploads/employee/{employee_id}/'
    ],
    'package' => [
        'individual' => 'INDIVIDUAL',
        'packaged' => 'PACKAGED'
    ],
    'repeatTraining' => [
        'no_repeat' => 'no_repeat',
        'repeat_daily' => 'repeat_daily',
        'repeat_weekly' => 'repeat_weekly',
        'repeat_monthly' => 'repeat_monthly',
        'repeat_yearly' => 'repeat_yearly'
    ],
    'gender' => [
        'male' => 'MALE',
        'female' => 'FEMALE',
        'all' => 'ALL'
    ],
    'contentType' => [
        'image' => 'IMAGE',
        'video' => 'VIDEO'
    ],
    'status' => [
        'active' => 'ACTIVE',
        'inactive' => 'INACTIVE',
        'closed' => 'CLOSED',
        'yes' => 'YES',
        'no' => 'NO'
    ],
    'league'=>[
      'league_types'=>[
          "MENS SINGLES LEAGUE" => "Mens' Singles League",
          "WOMENS SINGLES LEAGUE" => "Womens' Singles League",
          "MENS DOUBLES LEAGUE" => "Mens' Doubles League",
          "WOMENS DOUBLES LEAGUE" => "Womens' Doubles League",
          "MIX SINGLES LEAGUE" => "Mix Singles League",
          "MIX DOUBLES LEAGUE" => "Mix Doubles League",
      ],
      'abilityLevel'=>[
          '1.0'=>'1.0',
          '2.0'=>'2.0',
          '2.5'=>'2.5',
          '3.0'=>'3.0',
          '3.5'=>'3.5',
          '4.0'=>'4.0',
          '4.5'=>'4.5',
          '5.0'=>'5.0'
      ],
      "winning_criteria"=>[
        "match" => "MATCH",
        "points" => "POINTS",
        "sets" => "SETS"
      ],
      "structure_type"=>[
        "structured" => "STRUCTURED",
        "unstructured" => "UNSTRUCTURED"
      ],
      "days"=>[
        "monday"=>"MONDAY",
        "tuesday"=>"TUESDAY",
        "wednesday"=>"WEDNESDAY",
        "thursday"=>"THURSDAY",
        "friday"=>"FRIDAY",
        "saturday"=>"SATURDAY",
        "sunday"=>"SUNDAY",
      ],
      "unstructuredLeagueVariant"=>[
        "LADDER"=>"Ladder",
        "PYRAMID"=>"Pyramid",
        "POINT BASED"=>"Point Based"
      ],
     
    ],
    "nps_targets"=>[
      'trainingSession' => 'TrainingSession',
    ],
  'tournament'=>[
    'event_types'=>[
      "mens_singles"=>"MENS SINGLES",
      "womens_singles" =>"WOMENS SINGLES",
      "mens_doubles"=>"MENS DOUBLES",
      "womens_doubles" =>"WOMENS DOUBLES",
      "mix_singles" => "MIX SINGLES",
      "mix_doubles" => "MIX DOUBLES",
    ],
    'elimination_types'=>[
      "simple_elimination"=>"SIMPLE ELIMINATION",
      "double_elimination" =>"DOUBLE ELIMINATION",
      "round_robin" => "ROUND ROBIN"
    ],
    "status"=>[
      "reserved"=>"RESERVED",
      "pending"=>"PENDING",
      "pending_reserved"=>"PENDING RESERVED",
      "free"=>"FREE",
      "confirmed"=>"CONFIRMED",
      "cancel" => "CANCEL BOOKING",
      "refused" => "REFUSED",
      "booking" => "BOOKING"

    ],
    "winning_criteria"=>[
      "MATCH",
      "POINTS",
      "SETS"
    ],
    "days"=>[
      "monday"=>"MONDAY",
      "tuesday"=>"TUESDAY",
      "wednesday"=>"WEDNESDAY",
      "thursday"=>"THURSDAY",
      "friday"=>"FRIDAY",
      "saturday"=>"SATURDAY",
      "sunday"=>"SUNDAY",
    ],

  ],
  "clubPermissions"=>[
    "reservations" => "Reservations",
    "reports"=> "Reports",
    "members"=> "Members",
    "employees"=> "Employees",
    "beacons"=> "Beacons",
    "courts"=> "Courts",
    "coaches"=> "Coaches",
    "trainings"=> "Trainings",
    "photoGallery"=> "Photo Gallery",
    "news"=> "News",
    "clubWall"=> "Club Wall",
    "leagues"=> "Leagues",
    "tournaments"=> "Tournaments",
    "restaurant"=> "Restaurant",
    "posClient" => "POS Client"
  ],
  "restaurantOrders"=>[

    "payment_methods"=>[
      "cash"=>"Cash",
      "credit_card"=>"Credit Card",
      "debit_card" => "Debit Card",
      "tab" => "Tab"
    ]
    
  ]


];
