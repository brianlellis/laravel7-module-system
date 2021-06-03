<?php

namespace App\Console\Commands\Tests;

use Carbon\Carbon;
use Illuminate\Console\Command;

class CreditReport extends Command
{
  protected $signature   = 'rapyd:test:creditreport {--action=list}';
  protected $description = 'Testing Harness For Credit Reports';

  public function __construct()
  {
    parent::__construct();
  }

  public function handle()
  {
  }

  //SANDBOX TEST DATA FUNCTIONS
  public static function getTestReport($test_idx)
  {
    $info_data = self::formTestData($test_idx);
    return self::getReport($info_data);
  }

  protected static function formTestData($data_idx)
  {
    $data_arr = array(
      0 => '{"consumerPii":{"primaryApplicant":{"name":{"lastName":"CANN","firstName":"JOHN","middleName":"N"},"dob":{"dob":"1955"},"ssn":{"ssn":"111111111"},"currentAddress":{"line1":"510 MONDRE ST","city":"MICHIGAN CITY","state":"IN","zipCode":"46360"}}},"requestor":{"subscriberCode":"2222222"},"permissiblePurpose":{"type":"08"},"resellerInfo":{"endUserName":"CPAPIV2TC21"},"addOns":{"directCheck":"","demographics":"Only Phone","clarityEarlyRiskScore":"Y","clarityData":{"clarityAccountId":"0000000","clarityLocationId":"000000","clarityControlFileName":"test_file","clarityControlFileVersion":"0000000"},"renterRiskScore":"N","rentBureauData":{"primaryApplRentBureauFreezePin":"1234","secondaryApplRentBureauFreezePin":"112233"},"riskModels":{"modelIndicator":[""],"scorePercentile":""},"summaries":{"summaryType":[""]},"fraudShield":"Y","mla":"","ofacmsg":"","consumerIdentCheck":{"getUniqueConsumerIdentifier":""},"joint":"","paymentHistory84":"","syntheticId":"N","taxRefundLoan":"Y"},"customOptions":{"optionId":["COADEX"]}}'
      , 1 => '{"consumerPii":{"primaryApplicant":{"name":{"lastName":"ARMSTRONG","firstName":"KARL","middleName":"E"},"dob":{"dob":"1959"},"ssn":{"ssn":"111111111"},"currentAddress":{"line1":"1073 BUCKINGHAM DR","city":"CAROL STREAM","state":"IL","zipCode":"60188"}},"secondaryApplicant":{"name":{"lastName":"REYNOLDS","firstName":"ROBERTS"},"dob":{"dob":"10041962"},"ssn":{"ssn":"333333333"},"driverslicense":{"number":"A00000000000","state":"CT"},"employment":{"employerName":"HOMELAND SECURITY"}}},"requestor":{"subscriberCode":"2222222"},"permissiblePurpose":{"type":""},"resellerInfo":{"endUserName":"CPAPIV2TC24"},"addOns":{"directCheck":"","demographics":"Geocode and Phone","clarityEarlyRiskScore":"Y","clarityData":{"clarityAccountId":"0000000","clarityLocationId":"000000","clarityControlFileName":"test_file2","clarityControlFileVersion":"0000000"},"renterRiskScore":"Y","rentBureauData":{"primaryApplRentBureauFreezePin":"1234","secondaryApplRentBureauFreezePin":"112233"},"riskModels":{"modelIndicator":[""],"scorePercentile":""},"summaries":{"summaryType":[""]},"fraudShield":"Y","mla":"","ofacmsg":"","consumerIdentCheck":{"getUniqueConsumerIdentifier":""},"joint":"","paymentHistory84":"","syntheticId":"Y","taxRefundLoan":"N"},"customOptions":{"optionId":[""]}}'
      , 2 => '{"consumerPii":{"primaryApplicant":{"name":{"lastName":"ARMSTRONG","firstName":"KARL","middleName":"E"},"dob":{"dob":"1959"},"ssn":{"ssn":"111111111"},"currentAddress":{"line1":"1073 BUCKINGHAM DR","city":"CAROL STREAM","state":"IL","zipCode":"60188"}},"secondaryApplicant":{"dob":{"dob":"10041962"},"ssn":{"ssn":""},"driverslicense":{"number":"A24606453181","state":"CT"},"employment":{"employerName":"HOMELAND SECURITY"}}},"requestor":{"subscriberCode":"2222222"},"permissiblePurpose":{"type":""},"resellerInfo":{"endUserName":"CPAPIV2TC26"},"addOns":{"directCheck":"","demographics":"Geocode and Phone","clarityEarlyRiskScore":"N","clarityData":{"clarityAccountId":"0000000","clarityLocationId":"000000","clarityControlFileName":"test_file","clarityControlFileVersion":"0000000"},"renterRiskScore":"N","rentBureauData":{"primaryApplRentBureauFreezePin":"1234","secondaryApplRentBureauFreezePin":"112233"},"riskModels":{"modelIndicator":[""],"scorePercentile":""},"summaries":{"summaryType":[""]},"fraudShield":"Y","mla":"","ofacmsg":"","consumerIdentCheck":{"getUniqueConsumerIdentifier":""},"joint":"","paymentHistory84":"","syntheticId":"N"},"customOptions":{"optionId":[""]}}'
      , 3 => '{"consumerPii":{"primaryApplicant":{"name":{"lastName":"NATIUIDAD","firstName":"KATHLEEN","middleName":"K"},"dob":{"dob":"1959"},"ssn":{"ssn":"111111111"},"currentAddress":{"line1":"3878 DAKLAWN AVE","city":"DALLAS","state":"TX","zipCode":"75219"}},"secondaryApplicant":{"name":{"lastName":"JAY","firstName":"JUDY","generationCode":"II"},"ssn":{"ssn":"333333333"}}},"requestor":{"subscriberCode":"2222222"},"permissiblePurpose":{"type":""},"resellerInfo":{"endUserName":"CPAPIV2TC27"},"freezeOverride":{"primaryApplFreezeOverrideCode":"000002522653451","secondaryApplFreezeOverrideCode":"000002909814012"},"addOns":{"directCheck":"","demographics":"Geocode and Phone","clarityEarlyRiskScore":"N","clarityData":{"clarityAccountId":"0000000","clarityLocationId":"000000","clarityControlFileName":"test_file","clarityControlFileVersion":"0000000"},"renterRiskScore":"N","rentBureauData":{"primaryApplRentBureauFreezePin":"1234","secondaryApplRentBureauFreezePin":"112233"},"riskModels":{"modelIndicator":["M2","F1","N","V","AA","AB","AD","SP","V3","AG"],"scorePercentile":""},"summaries":{"summaryType":[""]},"fraudShield":"","mla":"","ofacmsg":"","consumerIdentCheck":{"getUniqueConsumerIdentifier":""},"joint":"Y","paymentHistory84":""},"customOptions":{"optionId":[""]}}'
      , 4 => '{"consumerPii":{"primaryApplicant":{"name":{"lastName":"NATIUIDAD","firstName":"KATHLEEN","middleName":"K"},"dob":{"dob":"1959"},"ssn":{"ssn":"111111111"},"currentAddress":{"line1":"3878 DAKLAWN AVE","city":"DALLAS","state":"TX","zipCode":"75219"}},"secondaryApplicant":{"name":{"lastName":"JAY","firstName":"JUDY","generationCode":"II"},"ssn":{"ssn":"333333333"}}},"requestor":{"subscriberCode":"2222222"},"permissiblePurpose":{"type":"48"},"resellerInfo":{"endUserName":"CPAPIV2TC28"},"addOns":{"directCheck":"","demographics":"Geocode and Phone","clarityEarlyRiskScore":"N","clarityData":{"clarityAccountId":"0000000","clarityLocationId":"000000","clarityControlFileName":"test_file","clarityControlFileVersion":"0000000"},"renterRiskScore":"Y","rentBureauData":{"primaryApplRentBureauFreezePin":"1234","secondaryApplRentBureauFreezePin":"112233"},"riskModels":{"modelIndicator":[],"scorePercentile":""},"summaries":{"summaryType":["Profile Summary"]},"fraudShield":"","mla":"","ofacmsg":"Y","consumerIdentCheck":{"getUniqueConsumerIdentifier":""},"joint":"Y","paymentHistory84":""},"customOptions":{"optionId":[""]}}'
    );

    return $data_arr[$data_idx];
  }
}