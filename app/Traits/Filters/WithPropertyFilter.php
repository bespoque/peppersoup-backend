<?php

namespace App\Traits\Filters;

use Illuminate\Database\Eloquent\Builder;

trait WithPropertyFilter
{

    /**
     * @param Builder $query
     * @return Builder
     */
    private function withFilters(Builder $query): Builder
    {
        $request = request();
        return $query
            ->where(function ($query) use ($request) {

                if ($total_price_min = $request->total_price_min) {
                    if (!empty($total_price_min)) {
                        $query->where("total_price_min", $total_price_min);
                    }
                }

                if ($total_price_max = $request->total_price_max) {
                    if (!empty($total_price_max)) {
                        $query->where("total_price_max", $total_price_max);
                    }
                }

                if ($nightly_price_min = $request->nightly_price_min) {
                    if (!empty($nightly_price_min)) {
                        $query->where("nightly_price_min", $nightly_price_min);
                    }
                }

                if ($nightly_price_max = $request->nightly_price_max) {
                    if (!empty($nightly_price_max)) {
                        $query->where("nightly_price_max", $nightly_price_max);
                    }
                }


//                if ($amenities_ids = $request->amenities_ids) {
//                    if (!empty($amenities_ids)) {
//                        $query->where("user_id", $amenities_ids);
//                    }
//                }

//                if ($property_type_ids = $request->property_type_ids) {
//                    if (!empty($property_type_ids)) {
//                        $query->where("biller_ref", $property_type_ids);
//                    }
//                }

//                if ($accessibility_feature_ids = $request->accessibility_feature_ids) {
//                    if (!empty($accessibility_feature_ids)) {
//                        $query->where("transaction_module_ref", $accessibility_feature_ids);
//                    }
//                }

//                if ($property_booking_choices_ids = $request->property_booking_choices_ids) {
//                    if (!empty($property_booking_choices_ids)) {
//                        $query->where("service_type", $property_booking_choices_ids);
//                    }
//                }

                if ($free_cancellation = $request->free_cancellation) {
                    if (!empty($free_cancellation)) {
                        $query->where("free_cancellation", $free_cancellation);
                    }
                }

//                if ($event_venue_categories_ids = $request->event_venue_categories_ids) {
//                    if (!empty($event_venue_categories_ids)) {
//                        $query->where("service_type", $event_venue_categories_ids);
//                    }
//                }

//                if ($property_booking_choices_id = $request->property_booking_choices_id) {
//                    if (!empty($property_booking_choices_id)) {
//                        $query->where("service_type", $property_booking_choices_id);
//                    }
//                }


//                if ($event_guest_capacities_ids = $request->event_guest_capacities_ids) {
//                    if (!empty($serviceType)) {
//                        $query->where("service_type", $event_guest_capacities_ids);
//                    }
//                }


//                if ($event_types_ids = $request->event_types_ids) {
//                    if (!empty($serviceType)) {
//                        $query->where("service_type", $serviceType);
//                    }
//                }


                if ($square_feet_min = $request->square_feet_min) {
                    if (!empty($square_feet_min)) {
                        $query->where("square_feet_min", $square_feet_min);
                    }
                }

                if ($square_feet_max = $request->square_feet_max) {
                    if (!empty($square_feet_max)) {
                        $query->where("square_feet_max", $square_feet_max);
                    }
                }


                if ($lot_size_min = $request->lot_size_min) {
                    if (!empty($lot_size_min)) {
                        $query->where("lot_size_min", $lot_size_min);
                    }
                }


                if ($lot_size_max = $request->lot_size_max) {
                    if (!empty($lot_size_max)) {
                        $query->where("lot_size_max", $lot_size_max);
                    }
                }


                if ($stores_min = $request->stores_min) {
                    if (!empty($stores_min)) {
                        $query->where("stores_min", $stores_min);
                    }
                }


                if ($stores_max = $request->stores_max) {
                    if (!empty($stores_max)) {
                        $query->where("stores_max", $stores_max);
                    }
                }


                if ($year_built_min = $request->year_built_min) {
                    if (!empty($year_built_min)) {
                        $query->where("year_built_min", $year_built_min);
                    }
                }


                if ($year_built_max = $request->year_built_max) {
                    if (!empty($year_built_max)) {
                        $query->where("year_built_max", $year_built_max);
                    }
                }

                if ($state_id = $request->state_id) {
                    if (!empty($state_id)) {
                        $query->where("state_id", $state_id);
                    }
                }


                if ($area_id = $request->area_id) {
                    if (!empty($area_id)) {
                        $query->where("area_id", $area_id);
                    }
                }

                if ($country_id = $request->country_id) {
                    if (!empty($country_id)) {
                        $query->where("country_id", $country_id);
                    }
                }

            });
    }

}
