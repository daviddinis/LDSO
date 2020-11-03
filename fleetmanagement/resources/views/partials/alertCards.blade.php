<div class="alertCardsSection row">
    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        @include('partials.alertCard', ['category' => 'Insurance', 'alertTimes' => $alertTimez, 'eventDate' => $insuranceDate])
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        @include('partials.alertCard', ['category' => 'Tax', 'alertTimes' => $alertTimez, 'eventDate' => $taxDate])
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        @include('partials.alertCard', ['category' => 'Inspection', 'alertTimes' => $alertTimez, 'eventDate' => $inspectionDate])
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        @include('partials.alertCard', ['category' => 'Maintenance', 'alertTimes' => $alertTimez, 'eventDate' => $maintenanceDate])
    </div>
</div>
