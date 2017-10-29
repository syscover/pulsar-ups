<?php namespace Syscover\Ups\Entities;


class PackagingType
{
    const PT_UNKNOWN = '00';
    const PT_UPSLETTER = '01';
    const PT_PACKAGE = '02';
    const PT_TUBE = '03';
    const PT_PAK = '04';
    const PT_UPS_EXPRESSBOX = '21';
    const PT_UPS_25KGBOX = '24';
    const PT_UPS_10KGBOX = '25';
    const PT_PALLET = '30';
    const PT_EXPRESSBOX_S = '2a';
    const PT_EXPRESSBOX_M = '2b';
    const PT_EXPRESSBOX_L = '2c';
    const PT_FLATS = '56';
    const PT_PARCELS = '57';
    const PT_BPM = '58';
    const PT_FIRST_CLASS = '59';
    const PT_PRIORITY = '60';
    const PT_MACHINABLES = '61';
    const PT_IRREGULARS = '62';
    const PT_PARCEL_POST = '63';
    const PT_BPM_PARCEL = '64';
    const PT_MEDIA_MAIL = '65';
    const PT_BPM_FLAT = '66';
    const PT_STANDARD_FLAT = '67';
}