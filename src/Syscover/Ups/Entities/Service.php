<?php namespace Syscover\Ups\Entities;

class Service
{
    // Valid domestic values
    const S_AIR_1DAYEARLYAM = '14';
    const S_AIR_1DAY = '01';
    const S_AIR_1DAYSAVER = '13';
    const S_AIR_2DAYAM = '59';
    const S_AIR_2DAY = '02';
    const S_3DAYSELECT = '12';
    const S_GROUND = '03';
    const S_SURE_POST = '93';

    // Valid international values
    const S_STANDARD = '11';
    const S_WW_EXPRESS = '07';
    const S_WW_EXPRESSPLUS = '54';
    const S_WW_EXPEDITED = '08';
    const S_SAVER = '65'; // Require for Rating, ignored for Shopping
    const S_ACCESS_POINT = '70'; // Access Point Economy

    // Valid Poland to Poland same day values
    const S_UPSTODAY_STANDARD = '82';
    const S_UPSTODAY_DEDICATEDCOURIER = '83';
    const S_UPSTODAY_INTERCITY = '84';
    const S_UPSTODAY_EXPRESS = '85';
    const S_UPSTODAY_EXPRESSSAVER = '86';
    const S_UPSWW_EXPRESSFREIGHT = '96';

    // Time in Transit Response Service Codes: United States Domestic Shipments
    const TT_S_US_AIR_1DAYAM    = '1DM';  // UPS Next Day Air Early
    const TT_S_US_AIR_1DAY      = '1DA';  // UPS Next Day Air
    const TT_S_US_AIR_SAVER     = '1DP';  // UPS Next Day Air Saver
    const TT_S_US_AIR_2DAYAM    = '2DM';  // UPS Second Day Air A.M.
    const TT_S_US_AIR_2DAY      = '2DA';  // UPS Second Day Air
    const TT_S_US_3DAYSELECT    = '3DS';  // UPS Three-Day Select
    const TT_S_US_GROUND        = 'GND';  // UPS Ground
    const TT_S_US_AIR_1DAYSATAM = '1DMS'; // UPS Next Day Air Early (Saturday Delivery)
    const TT_S_US_AIR_1DAYSAT   = '1DAS'; // UPS Next Day Air (Saturday Delivery)
    const TT_S_US_AIR_2DAYSAT   = '2DAS'; // UPS Second Day Air (Saturday Delivery)

    // Time in Transit Response Service Codes: Other Shipments Originating in US
    const TT_S_US_INTL_EXPRESSPLUS = '21';  // UPS Worldwide Express Plus
    const TT_S_US_INTL_EXPRESS     = '01';  // UPS Worldwide Express
    const TT_S_US_INTL_SAVER       = '28';  // UPS Worldwide Express Saver
    const TT_S_US_INTL_STANDARD    = '03';  // UPS Standard
    const TT_S_US_INTL_EXPEDITED   = '05';  // UPS Worldwide Expedited

    // Time in Transit Response Service Codes: Shipments Originating in the EU
    // Destination is WITHIN the Origin Country
    const TT_S_EU_EXPRESSPLUS  = '23';  // UPS Express Plus
    const TT_S_EU_EXPRESS      = '24';  // UPS Express
    const TT_S_EU_SAVER        = '26';  // UPS Express Saver
    const TT_S_EU_STANDARD     = '25';  // UPS Standard

    // Time in Transit Response Service Codes: Shipments Originating in the EU
    // Destination is Another EU Country
    const TT_S_EU_TO_EU_EXPRESSPLUS  = '22';  // UPS Express Plus
    const TT_S_EU_TO_EU_EXPRESS      = '10';  // UPS Express
    const TT_S_EU_TO_EU_SAVER        = '18';  // UPS Express Saver
    const TT_S_EU_TO_EU_STANDARD     = '08';  // UPS Standard

    // Time in Transit Response Service Codes: Shipments Originating in the EU
    // Destination is Outside the EU
    const TT_S_EU_TO_OTHER_EXPRESS_NA1  = '11';  // UPS Express NA 1
    const TT_S_EU_TO_OTHER_EXPRESSPLUS  = '21';  // UPS Worldwide Express Plus
    const TT_S_EU_TO_OTHER_EXPRESS      = '01';  // UPS Express
    const TT_S_EU_TO_OTHER_SAVER        = '28';  // UPS Express Saver
    const TT_S_EU_TO_OTHER_EXPEDITED    = '05';  // UPS Expedited
    const TT_S_EU_TO_OTHER_STANDARD     = '68';  // UPS Standard
}