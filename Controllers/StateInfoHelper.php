<?php

use App\Frostbite\Jetsurety\StateInfo\Models\StateInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;

class StateInfoHelper
{
    public static function getStatesArray()
    {
      return array(
        'AL'=>'Alabama',
        'AK'=>'Alaska',
        'AZ'=>'Arizona',
        'AR'=>'Arkansas',
        'CA'=>'California',
        'CO'=>'Colorado',
        'CT'=>'Connecticut',
        'DE'=>'Delaware',
        'FL'=>'Florida',
        'GA'=>'Georgia',
        'HI'=>'Hawaii',
        'ID'=>'Idaho',
        'IL'=>'Illinois',
        'IN'=>'Indiana',
        'IA'=>'Iowa',
        'KS'=>'Kansas',
        'KY'=>'Kentucky',
        'LA'=>'Louisiana',
        'ME'=>'Maine',
        'MD'=>'Maryland',
        'MA'=>'Massachusetts',
        'MI'=>'Michigan',
        'MN'=>'Minnesota',
        'MS'=>'Mississippi',
        'MO'=>'Missouri',
        'MT'=>'Montana',
        'NE'=>'Nebraska',
        'NV'=>'Nevada',
        'NH'=>'New Hampshire',
        'NJ'=>'New Jersey',
        'NM'=>'New Mexico',
        'NC'=>'North Carolina',
        'ND'=>'North Dakota',
        'OH'=>'Ohio',
        'OK'=>'Oklahoma',
        'OR'=>'Oregon',
        'PA'=>'Pennsylvania',
        'RI'=>'Rhode Island',
        'SC'=>'South Carolina',
        'SD'=>'South Dakota',
        'TN'=>'Tennessee',
        'TX'=>'Texas',
        'UT'=>'Utah',
        'VT'=>'Vermont',
        'VA'=>'Virginia',
        'WA'=>'Washington',
        'WV'=>'West Virginia',
        'WI'=>'Wisconsin',
        'WY'=>'Wyoming',
      );
    }

    public static function getStateRatesArray($state_name)
    {
        $stateArray = array(
          'Alabama' => array(
            'records' => array(
              array(
                'name'     => 'Motor Vehicle Dealer Bond',
                'bond_app' => '$25,000 Motor Vehicle Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 12,
                  'standard'      => 21,
                  'credit_repair' => 47,
                ),
                'annual' => array(
                  'preferred'     => 125,
                  'standard'      => 250,
                  'credit_repair' => 599,
                )
              )
            )
          ),
          'Alaska' => array(
            'records' => array(
              array(
                'name'     => 'Used Vehicle Dealers',
                'bond_app' => '$50,000 Auto Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 21,
                  'standard'      => 42,
                  'credit_repair' => 94,
                ),
                'annual' => array(
                  'preferred'     => 250,
                  'standard'      => 500,
                  'credit_repair' => 1000,
                )
              ),
              array(
                'name'     => 'Motorcycle Dealers',
                'bond_app' => '$25,000 Bond for Motorcycle Dealers',
                'monthly'  => array(
                  'preferred'     => 13,
                  'standard'      => 21,
                  'credit_repair' => 47,
                ),
                'annual' => array(
                  'preferred'     => 150,
                  'standard'      => 250,
                  'credit_repair' => 500,
                )
              )
            )
          ),
          'Arizona' => array(
            'records' => array(
              array(
                'name'     => 'Used / Franchise Car Dealers',
                'bond_app' => '$100,000 Used/Franchise Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 56,
                  'standard'      => 83,
                  'credit_repair' => 219,
                ),
                'annual' => array(
                  'preferred'     => 675,
                  'standard'      => 1000,
                  'credit_repair' => 2400,
                )
              ),
              array(
                'name'     => 'Wholesale / Broker Car Dealers',
                'bond_app' => '$25,000 Wholesale/Broker Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 13,
                  'standard'      => 27,
                  'credit_repair' => 47,
                ),
                'annual' => array(
                  'preferred'     => 150,
                  'standard'      => 325,
                  'credit_repair' => 500,
                )
              ),
              array(
                'name'     => 'Motor Vehicle Dealer Bond',
                'bond_app' => '$20,000 Automotive Recycler Bond',
                'monthly'  => array(
                  'preferred'     => 11,
                  'standard'      => 22,
                  'credit_repair' => 38,
                ),
                'annual' => array(
                  'preferred'     => 120,
                  'standard'      => 260,
                  'credit_repair' => 400,
                )
              )
            )
          ),
          'Arkansas' => array(
            'records' => array(
              array(
                'name'     => 'Used / Wholesale Dealers',
                'bond_app' => '$50,000 New Car Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 10,
                  'standard'      => 32,
                  'credit_repair' => 70,
                ),
                'annual' => array(
                  'preferred'     => 100,
                  'standard'      => 375,
                  'credit_repair' => 750,
                )
              ),
              array(
                'name'     => 'Motorcycle, ATV, UTV, Scooter Dealers',
                'bond_app' => '$25,000 Used Motor Vehicle Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 10,
                  'standard'      => 32,
                  'credit_repair' => 70,
                ),
                'annual' => array(
                  'preferred'     => 100,
                  'standard'      => 375,
                  'credit_repair' => 750,
                )
              ),
              array(
                'name'     => 'New Dealers',
                'bond_app' => '$25,000 Motorcycle, ATV, UTV, and Scooter Dealers / Lessors',
                'monthly'  => array(
                  'preferred'     => 17,
                  'standard'      => 50,
                  'credit_repair' => 135,
                ),
                'annual' => array(
                  'preferred'     => 200,
                  'standard'      => 600,
                  'credit_repair' => 1500,
                )
              )
            )
          ),
          'California' => array(
            'records' => array(
              array(
                'name'     => 'Used & Wholesale Car Dealers',
                'bond_app' => 'Used Auto Dealer / Wholesale Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 34,
                  'standard'      => 83,
                  'credit_repair' => 177,
                ),
                'annual' => array(
                  'preferred'     => 369,
                  'standard'      => 949,
                  'credit_repair' => 1849,
                )
              ),
              array(
                'name'     => 'Wholesale Dealers 24 Cars or Less',
                'bond_app' => 'Wholesale Car Dealer who transacts 24 cars or less',
                'monthly'  => array(
                  'preferred'     => 10,
                  'standard'      => 17,
                  'credit_repair' => 38,
                ),
                'annual' => array(
                  'preferred'     => 89,
                  'standard'      => 175,
                  'credit_repair' => 375,
                )
              ),
              array(
                'name'     => 'Franchise / New Car Dealers',
                'bond_app' => 'Franchise Motor Vehicle Dealer',
                'monthly'  => array(
                  'preferred'     => 34,
                  'standard'      => 42,
                  'credit_repair' => 47,
                ),
                'annual' => array(
                  'preferred'     => 369,
                  'standard'      => 469,
                  'credit_repair' => 500,
                )
              ),
              array(
                'name'     => 'Motorcycle Dealers',
                'bond_app' => 'Motorcycle Only Dealer',
                'monthly'  => array(
                  'preferred'     => 10,
                  'standard'      => 17,
                  'credit_repair' => 38,
                ),
                'annual' => array(
                  'preferred'     => 89,
                  'standard'      => 175,
                  'credit_repair' => 375,
                )
              )
            ),
            'extra_bond_apps' => array(
              'Vehicle Registration Bond'
            )
          ),
          'Colorado'        => array(
            'records' => array(
              array(
                'name'     => 'Motor Vehicle/Powersport Salesperson',
                'bond_app' => false,
                'monthly'  => array(
                  'preferred'     => 10,
                  'standard'      => 19,
                  'credit_repair' => 42,
                ),
                'annual' => array(
                  'preferred'     => 100,
                  'standard'      => 225,
                  'credit_repair' => 450,
                )
              ),
              array(
                'name'     => 'Wholesale Dealers',
                'bond_app' => false,
                'monthly'  => array(
                  'preferred'     => 21,
                  'standard'      => 47,
                  'credit_repair' => 94,
                ),
                'annual' => array(
                  'preferred'     => 250,
                  'standard'      => 500,
                  'credit_repair' => 1000,
                )
              )
            )
          ),
          'Connecticut'     => array(
            'records' => array(
              array(
                'name'     => '$50,000 New/Used Dealers',
                'bond_app' => '$50,000 New or Used Motor Vehicle Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 21,
                  'standard'      => 44,
                  'credit_repair' => 94,
                ),
                'annual' => array(
                  'preferred'     => 250,
                  'standard'      => 525,
                  'credit_repair' => 1000,
                )
              )
            )
          ),
          'Delaware'        => array(
            'records' => array(
              array(
                'name'     => 'Used / Franchise Car Dealers',
                'bond_app' => '$25,000 Motor Vehicle Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 13,
                  'standard'      => 27,
                  'credit_repair' => 47,
                ),
                'annual' => array(
                  'preferred'     => 150,
                  'standard'      => 325,
                  'credit_repair' => 500,
                )
              )
            )
          ),
          'Florida'         => array(
            'records' => array(
              array(
                'name'     => 'Used Motor Vehicle Dealers',
                'bond_app' => 'Used Motor Vehicle Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 15,
                  'standard'      => 38,
                  'credit_repair' => 83,
                ),
                'annual' => array(
                  'preferred'     => 169,
                  'standard'      => 450,
                  'credit_repair' => 1000,
                )
              ),
              array(
                'name'     => 'Franchise / New Auto Dealers',
                'bond_app' => 'Franchise Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 15,
                  'standard'      => 19,
                  'credit_repair' => 19,
                ),
                'annual' => array(
                  'preferred'     => 169,
                  'standard'      => 225,
                  'credit_repair' => 225,
                )
              ),
              array(
                'name'     => 'Mobile Home Dealers',
                'bond_app' => 'Mobile Home Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 13,
                  'standard'      => 32,
                  'credit_repair' => 47,
                ),
                'annual' => array(
                  'preferred'     => 150,
                  'standard'      => 375,
                  'credit_repair' => 500,
                )
              ),
              array(
                'name'     => 'Recreational Vehicle Dealers',
                'bond_app' => 'Recreational Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 9,
                  'standard'      => 17,
                  'credit_repair' => 28,
                ),
                'annual' => array(
                  'preferred'     => 100,
                  'standard'      => 200,
                  'credit_repair' => 300,
                )
              )
            )
          ),
          'Georgia'         => array(
            'records' => array(
              array(
                'name'     => 'Used Motor Vehicle Dealers',
                'bond_app' => '$35,000 Used Auto Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 15,
                  'standard'      => 32,
                  'credit_repair' => 70,
                ),
                'annual' => array(
                  'preferred'     => 280,
                  'standard'      => 613,
                  'credit_repair' => 1050,
                )
              )
            )
          ),
          'Hawaii'    => array(
            'records' => array(
              array(
                'name'     => '',
                'bond_app' => '',
                'monthly'  => array(
                  'preferred'     => 0,
                  'standard'      => 0,
                  'credit_repair' => 0,
                ),
                'annual' => array(
                  'preferred'     => 0,
                  'standard'      => 0,
                  'credit_repair' => 0,
                )
              )
            )
          ),
          'Idaho'           => array(
            'records' => array(
              array(
                'name'     => 'New/ UsedAuto Dealers',
                'bond_app' => '$20,000 Retail (Used/New) Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 10,
                  'standard'      => 19,
                  'credit_repair' => 47,
                ),
                'annual' => array(
                  'preferred'     => 100,
                  'standard'      => 220,
                  'credit_repair' => 500,
                )
              ),
              array(
                'name'     => 'Wholesale Car Dealers',
                'bond_app' => '$40,000 Wholesale Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 17,
                  'standard'      => 37,
                  'credit_repair' => 84,
                ),
                'annual' => array(
                  'preferred'     => 200,
                  'standard'      => 440,
                  'credit_repair' => 900,
                )
              ),
              array(
                'name'     => 'Motorcycle, ATV, UTV, Snowmobile Dealers',
                'bond_app' => '$10,000 Motorcycle, ATV, UTV, Snowmobile Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 10,
                  'standard'      => 15,
                  'credit_repair' => 28,
                ),
                'annual' => array(
                  'preferred'     => 100,
                  'standard'      => 150,
                  'credit_repair' => 300,
                )
              )
            )
          ),
          'Illinois'        => array(
            'records' => array(
              array(
                'name'     => 'New/Used Auto Dealers',
                'bond_app' => '$50,000 Motor Vehicle Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 42,
                  'standard'      => 83,
                  'credit_repair' => 177,
                ),
                'annual' => array(
                  'preferred'     => 500,
                  'standard'      => 1000,
                  'credit_repair' => 2000,
                )
              )
            )
          ),
          'Indiana'         => array(
            'records' => array(
              array(
                'name'     => '$25,000 Auto Dealer Bond',
                'bond_app' => '$25,000 Vehicle Merchandising Certificate/Bond',
                'monthly'  => array(
                  'preferred'     => 10,
                  'standard'      => 25,
                  'credit_repair' => 47,
                ),
                'annual' => array(
                  'preferred'     => 100,
                  'standard'      => 300,
                  'credit_repair' => 500,
                )
              )
            )
          ),
          'Iowa'            => array(
            'records' => array(
              array(
                'name'     => 'Used / Wholesale Dealers',
                'bond_app' => '$75,000 Motor Vehicle Dealer or Manufacturer Bond',
                'monthly'  => array(
                  'preferred'     => 24,
                  'standard'      => 63,
                  'credit_repair' => 104,
                ),
                'annual' => array(
                  'preferred'     => 281,
                  'standard'      => 750,
                  'credit_repair' => 1125,
                )
              ),
              array(
                'name'     => 'Trailer Dealers',
                'bond_app' => '$25,000 Bond for Trailer Dealers',
                'monthly'  => array(
                  'preferred'     => 12,
                  'standard'      => 32,
                  'credit_repair' => 70,
                ),
                'annual' => array(
                  'preferred'     => 125,
                  'standard'      => 375,
                  'credit_repair' => 750,
                )
              )
            )
          ),
          'Kansas'          => array(
            'records' => array(
              array(
                'name'     => '$30,000 Auto Dealer Bond',
                'bond_app' => '$30,000 Motor Vehicle Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 11,
                  'standard'      => 30,
                  'credit_repair' => 84,
                ),
                'annual' => array(
                  'preferred'     => 120,
                  'standard'      => 360,
                  'credit_repair' => 900,
                )
              )
            )
          ),
          'Kentucky'        => array(
            'records' => array(
              array(
                'name'     => 'Used / Franchise Car Dealers',
                'bond_app' => 'Motor Vehicle Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 10,
                  'standard'      => 19,
                  'credit_repair' => 38,
                ),
                'annual' => array(
                  'preferred'     => 100,
                  'standard'      => 225,
                  'credit_repair' => 450,
                )
              )
            )
          ),
          'Louisiana'       => array(
            'records' => array(
              array(
                'name'     => 'Used / Franchise Car Dealers',
                'bond_app' => '$50,000 Used Motor Vehicle Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 26,
                  'standard'      => 50,
                  'credit_repair' => 83,
                ),
                'annual' => array(
                  'preferred'     => 490,
                  'standard'      => 974,
                  'credit_repair' => 1750,
                )
              ),
              array(
                'name'     => 'New Car Dealers',
                'bond_app' => '$20,000 Franchise Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 11,
                  'standard'      => 23,
                  'credit_repair' => 37,
                ),
                'annual' => array(
                  'preferred'     => 196,
                  'standard'      => 438,
                  'credit_repair' => 700,
                )
              )
            ),
            'extra_bond_apps' => array(
              '$20,000 Specialty Dealer Bond'
            )
          ),
          'Maine'           => array(
            'records' => array(
              array(
                'name'     => '0-50 Vehicles Sold',
                'bond_app' => '0-50 Vehicles $25,000',
                'monthly'  => array(
                  'preferred'     => 13,
                  'standard'      => 27,
                  'credit_repair' => 47,
                ),
                'annual' => array(
                  'preferred'     => 150,
                  'standard'      => 325,
                  'credit_repair' => 500,
                )
              ),
              array(
                'name'     => '51-100 Vehicles Sold',
                'bond_app' => '51-100 Vehicles $50,000',
                'monthly'  => array(
                  'preferred'     => 25,
                  'standard'      => 54,
                  'credit_repair' => 94,
                ),
                'annual' => array(
                  'preferred'     => 300,
                  'standard'      => 650,
                  'credit_repair' => 1000,
                )
              ),
              array(
                'name'     => '101-150 Vehicles Sold',
                'bond_app' => '101-150 Vehicles $75,000',
                'monthly'  => array(
                  'preferred'     => 38,
                  'standard'      => 63,
                  'credit_repair' => 135,
                ),
                'annual' => array(
                  'preferred'     => 450,
                  'standard'      => 750,
                  'credit_repair' => 1500,
                )
              ),
              array(
                'name'     => '151+ Vehicles Sold',
                'bond_app' => '151+ Vehicles $100,000',
                'monthly'  => array(
                  'preferred'     => 50,
                  'standard'      => 83,
                  'credit_repair' => 177,
                ),
                'annual' => array(
                  'preferred'     => 600,
                  'standard'      => 1000,
                  'credit_repair' => 2000,
                )
              )
            )
          ),
          'Maryland'        => array(
            'records' => array(
              array(
                'name'     => '',
                'bond_app' => '',
                'monthly'  => array(
                  'preferred'     => 0,
                  'standard'      => 0,
                  'credit_repair' => 0,
                ),
                'annual' => array(
                  'preferred'     => 0,
                  'standard'      => 0,
                  'credit_repair' => 0,
                )
              )
            )
          ),
          'Massachusetts'   => array(
            'records' => array(
              array(
                'name'     => 'Motor Vehicle Dealer Bond',
                'bond_app' => '$25,000 Used Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 13,
                  'standard'      => 27,
                  'credit_repair' => 47,
                ),
                'annual' => array(
                  'preferred'     => 150,
                  'standard'      => 325,
                  'credit_repair' => 500,
                )
              )
            )
          ),
          'Michigan'        => array(
            'records' => array(
              array(
                'name'     => '$10,000 Michigan Dealer Bond',
                'bond_app' => '$10,000 Car Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 10,
                  'standard'      => 13,
                  'credit_repair' => 38,
                ),
                'annual' => array(
                  'preferred'     => 100,
                  'standard'      => 150,
                  'credit_repair' => 400,
                )
              )
            )
          ),
          'Minnesota'       => array(
            'records' => array(
              array(
                'name'     => '$50,000 Motor Vehicle Dealer Bond',
                'bond_app' => '$50,000  Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 21,
                  'standard'      => 44,
                  'credit_repair' => 93,
                ),
                'annual' => array(
                  'preferred'     => 250,
                  'standard'      => 525,
                  'credit_repair' => 1000,
                )
              )
            )
          ),
          'Mississippi'     => array(
            'records' => array(
              array(
                'name'     => 'Used Car Dealers',
                'bond_app' => '$15,000 Used Motor Vehicle Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 10,
                  'standard'      => 19,
                  'credit_repair' => 42,
                ),
                'annual' => array(
                  'preferred'     => 100,
                  'standard'      => 225,
                  'credit_repair' => 450,
                )
              ),
              array(
                'name'     => 'New Car Dealers',
                'bond_app' => '$25,000 New Motor Vehicle Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 12,
                  'standard'      => 32,
                  'credit_repair' => 70,
                ),
                'annual' => array(
                  'preferred'     => 125,
                  'standard'      => 375,
                  'credit_repair' => 750,
                )
              ),
              array(
                'name'     => 'New Car Dealers – Multiple Locations',
                'bond_app' => '	$100,000 New Motor Vehicle Dealer Bond – Multiple Locations',
                'monthly'  => array(
                  'preferred'     => 42,
                  'standard'      => 83,
                  'credit_repair' => 177,
                ),
                'annual' => array(
                  'preferred'     => 500,
                  'standard'      => 1000,
                  'credit_repair' => 2000,
                )
              )
            )
          ),
          'Missouri'        => array(
            'records' => array(
              array(
                'name'     => 'Used & New Car Dealers',
                'bond_app' => '$50,000 Motor Vehicle Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 21,
                  'standard'      => 42,
                  'credit_repair' => 135,
                ),
                'annual' => array(
                  'preferred'     => 250,
                  'standard'      => 500,
                  'credit_repair' => 1500,
                )
              )
            ),
            'extra_bond_apps' => array(
              '$100,000 Bond for Auctions or Lost Titles'
            )
          ),
          'Montana'         => array(
            'records' => array(
              array(
                'name'     => 'Used/New, Brokers, Wholesalers, Auctions, Manufactured Dwelling Bond',
                'bond_app' => '$50,000 Used/New Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 21,
                  'standard'      => 44,
                  'credit_repair' => 94,
                ),
                'annual' => array(
                  'preferred'     => 250,
                  'standard'      => 525,
                  'credit_repair' => 1000,
                )
              ),
              array(
                'name'     => 'Motorcycle / Quadricycle Dealer Bond',
                'bond_app' => '$15,000 Motorcycle Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 10,
                  'standard'      => 19,
                  'credit_repair' => 42,
                ),
                'annual' => array(
                  'preferred'     => 100,
                  'standard'      => 225,
                  'credit_repair' => 450,
                )
              ),
              array(
                'name'     => 'Motorboat, Personal Watercraft, Snowmobile, Off-Highway Vehicle Dealer Bond',
                'bond_app' => '$5,000 Bond for Boat, Watercraft, Snowmobile, and Off-highway Dealers',
                'monthly'  => array(
                  'preferred'     => 10,
                  'standard'      => 10,
                  'credit_repair' => 15,
                ),
                'annual' => array(
                  'preferred'     => 100,
                  'standard'      => 100,
                  'credit_repair' => 150,
                )
              )
            )
          ),
          'Nebraska'        => array(
            'records' => array(
              array(
                'name'     => '$50,000 Dealer Bond',
                'bond_app' => '$50,000 Auto Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 21,
                  'standard'      => 44,
                  'credit_repair' => 94,
                ),
                'annual' => array(
                  'preferred'     => 250,
                  'standard'      => 525,
                  'credit_repair' => 1000,
                )
              ),
              array(
                'name'     => '$100,000 Auction Bond',
                'bond_app' => '$100,000 Auction Bond',
                'monthly'  => array(
                  'preferred'     => 42,
                  'standard'      => 87,
                  'credit_repair' => 260,
                ),
                'annual' => array(
                  'preferred'     => 500,
                  'standard'      => 1050,
                  'credit_repair' => 3000,
                )
              )
            )
          ),
          'Nevada'          => array(
            'records' => array(
              array(
                'name'     => '$100,000 Motor Vehicle Dealer Bond',
                'bond_app' => '$100,000 Bond for Brokers, Dealers, Rebuilers, Lessors, Distributors, Manufacturers, and Transporters',
                'monthly'  => array(
                  'preferred'     => 38,
                  'standard'      => 83,
                  'credit_repair' => 127,
                ),
                'annual' => array(
                  'preferred'     => 450,
                  'standard'      => 1000,
                  'credit_repair' => 1400,
                )
              ),
              array(
                'name'     => '$50,000 Motorcycles | Trailers 3,501 lbs. or more Bond',
                'bond_app' => '$50,000 Bond for Motorcycles and Trailers weighing 3,501 lbs or greater',
                'monthly'  => array(
                  'preferred'     => 17,
                  'standard'      => 31,
                  'credit_repair' => 79,
                ),
                'annual' => array(
                  'preferred'     => 200,
                  'standard'      => 375,
                  'credit_repair' => 850,
                )
              ),
              array(
                'name'     => '$10,000 Motorcycles | Trailers 3,500 lbs or less Bond',
                'bond_app' => '$10,000 Bond for Utility or Boat Trailers weighing 3,500 lbs/ or less',
                'monthly'  => array(
                  'preferred'     => 9,
                  'standard'      => 21,
                  'credit_repair' => 38,
                ),
                'annual' => array(
                  'preferred'     => 100,
                  'standard'      => 225,
                  'credit_repair' => 400,
                )
              )
            )
          ),
          'New Hampshire'   => array(
            'records' => array(
              array(
                'name'     => '$25,000 Dealer Bond',
                'bond_app' => '$25,000 Motor Vehicle Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 13,
                  'standard'      => 21,
                  'credit_repair' => 47,
                ),
                'annual' => array(
                  'preferred'     => 150,
                  'standard'      => 250,
                  'credit_repair' => 500,
                )
              )
            )
          ),
          'New Jersey'      => array(
            'records' => array(
              array(
                'name'     => '$10,000 New Jersey Dealer Bond',
                'bond_app' => '$50,000 Motor Vehicle Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 10,
                  'standard'      => 19,
                  'credit_repair' => 37,
                ),
                'annual' => array(
                  'preferred'     => 100,
                  'standard'      => 200,
                  'credit_repair' => 400,
                )
              )
            )
          ),
          'New Mexico'      => array(
            'records' => array(
              array(
                'name'     => 'Motor Vehicle Dealer Bond',
                'bond_app' => '$50,000 Auto Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 21,
                  'standard'      => 44,
                  'credit_repair' => 94,
                ),
                'annual' => array(
                  'preferred'     => 250,
                  'standard'      => 525,
                  'credit_repair' => 1000,
                )
              ),
              array(
                'name'     => 'Motorcycle Dealer Bond',
                'bond_app' => '$12,500 Motorcycle Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 10,
                  'standard'      => 16,
                  'credit_repair' => 35,
                ),
                'annual' => array(
                  'preferred'     => 100,
                  'standard'      => 188,
                  'credit_repair' => 375,
                )
              )
            )
          ),
          'New York'        => array(
            'records' => array(
              array(
                'name'     => '$20,000 Bond: 6-50 Vehicles Sold Per Year',
                'bond_app' => '$20,000 Bond: 6-50 Vehicles Sold Per Year',
                'monthly'  => array(
                  'preferred'     => 10,
                  'standard'      => 32,
                  'credit_repair' => 78,
                ),
                'annual' => array(
                  'preferred'     => 100,
                  'standard'      => 375,
                  'credit_repair' => 826,
                )
                ),
              array(
                'name'     => '$100,000 Bond: 51-100 Vehicles Sold Per Year',
                'bond_app' => '$100,000 Bond: 51-100 Vehicles Sold Per Year',
                'monthly'  => array(
                  'preferred'     => 38,
                  'standard'      => 80,
                  'credit_repair' => 152,
                ),
                'annual' => array(
                  'preferred'     => 450,
                  'standard'      => 1000,
                  'credit_repair' => 1700,
                )
                ),
              array(
                'name'     => '$50,000 Bond: Franchise Auto Dealers',
                'bond_app' => '$50,000 Bond: Franchise Auto Dealers',
                'monthly'  => array(
                  'preferred'     => 19,
                  'standard'      => 40,
                  'credit_repair' => 94,
                ),
                'annual' => array(
                  'preferred'     => 225,
                  'standard'      => 500,
                  'credit_repair' => 1000,
                )
              )
            )
          ),
          'North Carolina'  => array(
            'records' => array(
              array(
                'name'     => '$50,000 Bond',
                'bond_app' => '$50,000 Motor Vehicle Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 20,
                  'standard'      => 42,
                  'credit_repair' => 94,
                ),
                'annual' => array(
                  'preferred'     => 240,
                  'standard'      => 505,
                  'credit_repair' => 1000,
                )
              ),
              array(
                'name'     => 'Additional $25,000 Salesroom Bond',
                'bond_app' => false,
                'monthly'  => array(
                  'preferred'     => 10,
                  'standard'      => 25,
                  'credit_repair' => 70,
                ),
                'annual' => array(
                  'preferred'     => 100,
                  'standard'      => 300,
                  'credit_repair' => 750,
                )
              )
            )
          ),
          'North Dakota'    => array(
            'records' => array(
              array(
                'name'     => 'Used Dealer Bond',
                'bond_app' => '$25,000 Motor Vehicle Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 12,
                  'standard'      => 32,
                  'credit_repair' => 70,
                ),
                'annual' => array(
                  'preferred'     => 125,
                  'standard'      => 375,
                  'credit_repair' => 750,
                )
              ),
              array(
                'name'     => 'Mobile Home Dealer Bond',
                'bond_app' => '$50,000 Mobile Home Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 21,
                  'standard'      => 44,
                  'credit_repair' => 104,
                ),
                'annual' => array(
                  'preferred'     => 250,
                  'standard'      => 525,
                  'credit_repair' => 1125,
                )
              ),
              array(
                'name'     => 'Trailer Dealer Bond',
                'bond_app' => '$10,000 Trailer Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 10,
                  'standard'      => 19,
                  'credit_repair' => 25,
                ),
                'annual' => array(
                  'preferred'     => 100,
                  'standard'      => 200,
                  'credit_repair' => 300,
                )
              ),
              array(
                'name'     => 'Motor-Powered Recreational Vehicle Dealer Bond',
                'bond_app' => '$10,000 Motor-Powered Recreational Vehicle Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 10,
                  'standard'      => 12,
                  'credit_repair' => 25,
                ),
                'annual' => array(
                  'preferred'     => 100,
                  'standard'      => 200,
                  'credit_repair' => 300,
                )
              )
            )
          ),
          'Ohio'            => array(
            'records' => array(
              array(
                'name'     => '$25,000 Dealer Bond',
                'bond_app' => '$25,000  Bond for Used Car Dealers',
                'monthly'  => array(
                  'preferred'     => 13,
                  'standard'      => 27,
                  'credit_repair' => 59,
                ),
                'annual' => array(
                  'preferred'     => 150,
                  'standard'      => 325,
                  'credit_repair' => 625,
                )
              )
            )
          ),
          'Oklahoma'        => array(
            'records' => array(
              array(
                'name'     => 'Rebuilders',
                'bond_app' => '$15,000 Bond for Rebuilders',
                'monthly'  => array(
                  'preferred'     => 10,
                  'standard'      => 14,
                  'credit_repair' => 25,
                ),
                'annual' => array(
                  'preferred'     => 100,
                  'standard'      => 165,
                  'credit_repair' => 300,
                )
              ),
              array(
                'name'     => 'Used Dealers',
                'bond_app' => '$25,000 Used / Wholesale/ Vehicle Crusher Bond',
                'monthly'  => array(
                  'preferred'     => 10,
                  'standard'      => 21,
                  'credit_repair' => 41,
                ),
                'annual' => array(
                  'preferred'     => 100,
                  'standard'      => 250,
                  'credit_repair' => 500,
                )
              ),
              array(
                'name'     => 'Auction',
                'bond_app' => '$30,000 Manufactured Home Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 17,
                  'standard'      => 41,
                  'credit_repair' => 70,
                ),
                'annual' => array(
                  'preferred'     => 200,
                  'standard'      => 500,
                  'credit_repair' => 750,
                )
              ),
              array(
                'name'     => 'Manufactured Home Dealers',
                'bond_app' => '$50,000 Bond for Auctions',
                'monthly'  => array(
                  'preferred'     => 20,
                  'standard'      => 50,
                  'credit_repair' => 110,
                ),
                'annual' => array(
                  'preferred'     => 240,
                  'standard'      => 600,
                  'credit_repair' => 1200,
                )
              )
            )
          ),
          'Oregon'          => array(
            'records' => array(
              array(
                'name'     => 'Motor Vehicle Dealer Bond',
                'bond_app' => '$50,000 Car Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 25,
                  'standard'      => 52,
                  'credit_repair' => 94,
                ),
                'annual' => array(
                  'preferred'     => 313,
                  'standard'      => 625,
                  'credit_repair' => 1000,
                )
              ),
              array(
                'name'     => 'Motorcycle, Moped, ATV, Snowmobile Bond',
                'bond_app' => '$10,000 Motorcycle, Moped, ATV, Snowmobile Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 9,
                  'standard'      => 19,
                  'credit_repair' => 28,
                ),
                'annual' => array(
                  'preferred'     => 100,
                  'standard'      => 200,
                  'credit_repair' => 300,
                )
              )
            )
          ),
          'Pennsylvania'    => array(
            'records' => array(
              array(
                'name'     => 'Auto Dealer / Manufacturer Bond',
                'bond_app' => '$20,000 Auto Dealer / Manufacturer Bond',
                'monthly'  => array(
                  'preferred'     => 10,
                  'standard'      => 31,
                  'credit_repair' => 75,
                ),
                'annual' => array(
                  'preferred'     => 100,
                  'standard'      => 375,
                  'credit_repair' => 800,
                )
              ),
              array(
                'name'     => 'Agent / Recreational Dealer Bond',
                'bond_app' => '$30,000 Bond for Full Agents and Recreational Dealers',
                'monthly'  => array(
                  'preferred'     => 12,
                  'standard'      => 37,
                  'credit_repair' => 90,
                ),
                'annual' => array(
                  'preferred'     => 125,
                  'standard'      => 450,
                  'credit_repair' => 960,
                )
              ),
              array(
                'name'     => 'Messenger Service Bond',
                'bond_app' => '$50,000 Messenger Service Bond',
                'monthly'  => array(
                  'preferred'     => 18,
                  'standard'      => 42,
                  'credit_repair' => 88,
                ),
                'annual' => array(
                  'preferred'     => 208,
                  'standard'      => 500,
                  'credit_repair' => 1065,
                )
              ),
              array(
                'name'     => 'Salvor Bond',
                'bond_app' => '$10,000 Bond for Salvors',
                'monthly'  => array(
                  'preferred'     => 10,
                  'standard'      => 19,
                  'credit_repair' => 47,
                ),
                'annual' => array(
                  'preferred'     => 100,
                  'standard'      => 200,
                  'credit_repair' => 500,
                )
              )
            )
          ),
          'Rhode Island'    => array(
            'records' => array(
              array(
                'name'     => 'Used / Franchise Car Dealers',
                'bond_app' => '$50,000 Auto Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 17,
                  'standard'      => 50,
                  'credit_repair' => 104,
                ),
                'annual' => array(
                  'preferred'     => 200,
                  'standard'      => 600,
                  'credit_repair' => 1125,
                )
              )
            )
          ),
          'South Carolina'  => array(
            'records' => array(
              array(
                'name'     => '$30,000 Retail Dealer Bond',
                'bond_app' => '$30,000 Car Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 13,
                  'standard'      => 38,
                  'credit_repair' => 84,
                ),
                'annual' => array(
                  'preferred'     => 150,
                  'standard'      => 450,
                  'credit_repair' => 900,
                )
              ),
              array(
                'name'     => '$15,000 Motorcycle Dealer Bond',
                'bond_app' => '$15,000 Motorcycle & Wholesale Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 10,
                  'standard'      => 29,
                  'credit_repair' => 70,
                ),
                'annual' => array(
                  'preferred'     => 100,
                  'standard'      => 338,
                  'credit_repair' => 750,
                )
              )
            )
          ),
          'South Dakota'    => array(
            'records' => array(
              array(
                'name'     => '$25,000 New & Used Dealer Bond',
                'bond_app' => '$25,000 New and Used Vehicle and Mobile Home Dealers',
                'monthly'  => array(
                  'preferred'     => 13,
                  'standard'      => 27,
                  'credit_repair' => 47,
                ),
                'annual' => array(
                  'preferred'     => 150,
                  'standard'      => 325,
                  'credit_repair' => 500,
                )
              ),
              array(
                'name'     => '$15,000 Wholesale Dealer Bond',
                'bond_app' => false,
                'monthly'  => array(
                  'preferred'     => 10,
                  'standard'      => 17,
                  'credit_repair' => 25,
                ),
                'annual' => array(
                  'preferred'     => 100,
                  'standard'      => 195,
                  'credit_repair' => 300,
                )
              ),
              array(
                'name'     => '$5,000 Motorcycle Dealer Bond',
                'bond_app' => '$5,000 Motorcycle, Off-Road Vehicle, and Snowmobile Dealers',
                'monthly'  => array(
                  'preferred'     => 10,
                  'standard'      => 10,
                  'credit_repair' => 10,
                ),
                'annual' => array(
                  'preferred'     => 100,
                  'standard'      => 100,
                  'credit_repair' => 100,
                )
              ),
              array(
                'name'     => '$10,000 Trailer Dealer Bond',
                'bond_app' => '$10,000 Dealers of Trailers over 3,000 lbs. and Emergency Vehicles',
                'monthly'  => array(
                  'preferred'     => 10,
                  'standard'      => 12,
                  'credit_repair' => 19,
                ),
                'annual' => array(
                  'preferred'     => 100,
                  'standard'      => 130,
                  'credit_repair' => 200,
                )
              )
            )
          ),
          'Tennessee'       => array(
            'records' => array(
              array(
                'name'     => '$50,000 Auto Dealer Bond',
                'bond_app' => '$50,000 Motor Vehicle Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 15,
                  'standard'      => 26,
                  'credit_repair' => 52,
                ),
                'annual' => array(
                  'preferred'     => 275,
                  'standard'      => 500,
                  'credit_repair' => 1000,
                )
              )
            )
          ),
          'Texas'           => array(
            'records' => array(
              array(
                'name'     => 'Used & New Car Dealers',
                'bond_app' => '$25,000 Motor Vehicle Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 11,
                  'standard'      => 20,
                  'credit_repair' => 39,
                ),
                'annual' => array(
                  'preferred'     => 200,
                  'standard'      => 375,
                  'credit_repair' => 750,
                )
              )
            )
          ),
          'Utah'            => array(
            'records' => array(
              array(
                'name'     => 'Used / New Car Dealer Bond',
                'bond_app' => '$75,000 Motor Vehicle Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 24,
                  'standard'      => 38,
                  'credit_repair' => 104,
                ),
                'annual' => array(
                  'preferred'     => 281,
                  'standard'      => 450,
                  'credit_repair' => 1125,
                )
              ),
              array(
                'name'     => 'Motorcycle Dealer Bond',
                'bond_app' => '$10,000 Motorcycle Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 10,
                  'standard'      => 19,
                  'credit_repair' => 28,
                ),
                'annual' => array(
                  'preferred'     => 100,
                  'standard'      => 200,
                  'credit_repair' => 300,
                )
              ),
              array(
                'name'     => 'Body Shop Bond',
                'bond_app' => '$20,000 Bond for Body Shops',
                'monthly'  => array(
                  'preferred'     => 10,
                  'standard'      => 17,
                  'credit_repair' => 38,
                ),
                'annual' => array(
                  'preferred'     => 100,
                  'standard'      => 200,
                  'credit_repair' => 400,
                )
              )
            )
          ),
          'Vermont'         => array(
            'records' => array(
              array(
                'name'     => '$35,000 New Applicant Bond',
                'bond_app' => '$35,000 New Applicant Motor Vehicle Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 18,
                  'standard'      => 38,
                  'credit_repair' => 66,
                ),
                'annual' => array(
                  'preferred'     => 210,
                  'standard'      => 455,
                  'credit_repair' => 700,
                )
              ),
              array(
                'name'     => '$20,000 Bond > 25 Cars',
                'bond_app' => '	$20,000 Bond for Dealers Selling Less Than 25 Vehicles Per Year',
                'monthly'  => array(
                  'preferred'     => 11,
                  'standard'      => 22,
                  'credit_repair' => 38,
                ),
                'annual' => array(
                  'preferred'     => 120,
                  'standard'      => 260,
                  'credit_repair' => 400,
                )
              ),
              array(
                'name'     => '$25,000 Bond 25-100 Cars',
                'bond_app' => '$25,000 Bond for Dealers Selling Between 25-100 Vehicles Per Year',
                'monthly'  => array(
                  'preferred'     => 13,
                  'standard'      => 27,
                  'credit_repair' => 47,
                ),
                'annual' => array(
                  'preferred'     => 150,
                  'standard'      => 325,
                  'credit_repair' => 500,
                )
              ),
              array(
                'name'     => '$30,000 Bond 101-250 Cars	',
                'bond_app' => '	$30,000 Bond for Dealers Selling Between 101-250 Vehicles Per Year',
                'monthly'  => array(
                  'preferred'     => 16,
                  'standard'      => 25,
                  'credit_repair' => 56,
                ),
                'annual' => array(
                  'preferred'     => 180,
                  'standard'      => 300,
                  'credit_repair' => 600,
                )
              ),
              array(
                'name'     => '$35,000 Bond 251+ Cars',
                'bond_app' => '$35,000 Bond for Dealers Selling 250+ Vehicles Per Year',
                'monthly'  => array(
                  'preferred'     => 18,
                  'standard'      => 38,
                  'credit_repair' => 66,
                ),
                'annual' => array(
                  'preferred'     => 210,
                  'standard'      => 455,
                  'credit_repair' => 700,
                )
              )
            )
          ),
          'Virginia'        => array(
            'records' => array(
              array(
                'name'     => '$50, 000 Car Dealer Bond',
                'bond_app' => '$50,000 Car Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 40,
                  'standard'      => 83,
                  'credit_repair' => 167,
                ),
                'annual' => array(
                  'preferred'     => 500,
                  'standard'      => 1000,
                  'credit_repair' => 1875,
                )
              )
            )
          ),
          'Washington'      => array(
            'records' => array(
              array(
                'name'     => '$30,000 Auto Dealer Bond',
                'bond_app' => '$30,000 Car Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 20,
                  'standard'      => 38,
                  'credit_repair' => 84,
                ),
                'annual' => array(
                  'preferred'     => 240,
                  'standard'      => 450,
                  'credit_repair' => 900,
                )
              )
            )
          ),
          'West Virginia'   => array(
            'records' => array(
              array(
                'name'     => 'West Virginia $25,000 Dealer Bond',
                'bond_app' => '$25,000 Auto Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 16,
                  'standard'      => 32,
                  'credit_repair' => 63,
                ),
                'annual' => array(
                  'preferred'     => 188,
                  'standard'      => 375,
                  'credit_repair' => 750,
                )
              )
            )
          ),
          'Wisconsin'       => array(
            'records' => array(
              array(
                'name'     => 'Retail Dealers',
                'bond_app' => '$50,000 Retail Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 17,
                  'standard'      => 41,
                  'credit_repair' => 83,
                ),
                'annual' => array(
                  'preferred'     => 175,
                  'standard'      => 500,
                  'credit_repair' => 1000,
                )
              ),
              array(
                'name'     => 'Recreational / Wholesale / Salvage / Wholesale Auction',
                'bond_app' => '$25,000 Bond for Recreational, Wholesale, Salvage, Wholesale Auction Dealers',
                'monthly'  => array(
                  'preferred'     => 11,
                  'standard'      => 21,
                  'credit_repair' => 47,
                ),
                'annual' => array(
                  'preferred'     => 100,
                  'standard'      => 250,
                  'credit_repair' => 500,
                )
              ),
              array(
                'name'     => 'Motorcycle / Moped Dealers',
                'bond_app' => '$5,000 Motorcycle / Moped Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 11,
                  'standard'      => 11,
                  'credit_repair' => 11,
                ),
                'annual' => array(
                  'preferred'     => 100,
                  'standard'      => 100,
                  'credit_repair' => 100,
                )
              )
            )
          ),
          'Wyoming'         => array(
            'records' => array(
              array(
                'name'     => '$25,000 Dealer Bond',
                'bond_app' => '$25,000 Dealer Bond',
                'monthly'  => array(
                  'preferred'     => 13,
                  'standard'      => 27,
                  'credit_repair' => 47,
                ),
                'annual' => array(
                  'preferred'     => 150,
                  'standard'      => 325,
                  'credit_repair' => 500,
                )
              )
            )
          )
        );

        return $stateArray[$state_name];
    }
}
