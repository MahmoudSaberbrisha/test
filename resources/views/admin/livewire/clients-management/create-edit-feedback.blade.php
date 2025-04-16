<div class="p-4">
    @if($feed_back_id == null)
    <input type="text" wire:model="query" wire:keyup="updateQuery" placeholder="🔍 {{__('Search by name or phone...')}}" class="form-control col-6">
    @endif

    @if(count($clients) > 0)
        <div class="table-responsive mt-5">
            <table class="table text-md-nowrap" id="example1">
                <thead>
                    <tr>
                        <th style="font-size: 12px !important;">{{__('Name')}}</th>
                        <th style="font-size: 12px !important;">{{__('Phone')}}</th>
                        <th style="font-size: 12px !important;">{{__('Mobile')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clients as $client)
                    <tr style="cursor: pointer;" wire:click="selectClient({{ $client->id }})">
                        <td>{{$client->name}}</td>
                        <td>{{$client->phone}}</td>
                        <td>{{$client->mobile}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @elseif (count($clients) == 0 && $query)
        <div class="text-center alert-info alert mt-5"><i class="fa fa-info-circle"></i> {{__('No records found')}}</div>
    @endif

    @if($selectedClient)
        <div class="p-4 mt-4 border rounded">
            <h2 class="text-lg font-bold">{{__('Client')}}: {{ $selectedClient->name }}</h2>
            <input type="hidden" name="client_id" value="{{$selectedClient->id}}">

            @if($selectedClient->feed_backs->count())
                <h3 class="mt-2 font-semibold">{{__('Previous Reviews')}} :</h3>
                    <div class="table-responsive mt-5">
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                                <tr>
                                    <th style="font-size: 12px !important;">{{__('Date')}}</th>
                                    <th style="font-size: 12px !important;">{{__('Bookings')}}</th>
                                    <th style="font-size: 12px !important;">{{__('Rating')}}</th>
                                    <th style="font-size: 12px !important;">{{__('Service Quality')}}</th>
                                    <th style="font-size: 12px !important;">{{__('Staff Behavior')}}</th>
                                    <th style="font-size: 12px !important;">{{__('Cleanliness')}}</th>
                                    <th style="font-size: 12px !important;">{{__('Comment')}}</th>
                                    <th style="font-size: 12px !important;">{{__('Experience Type')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($selectedClient->feed_backs as $feedback)
                                    @if($feed_back_id == $feedback->id)
                                        @continue
                                    @endif
                                <tr>
                                    <td>{{$feedback->created_at->format('Y-m-d')}}</td>
                                    <td>
                                        {{ 
                                            $feedback->booking_group->booking->branch->name . ' - ' .
                                            __(BOOKING_TYPES[$feedback->booking_group->booking->booking_type])  . ' - ' .
                                            $feedback->booking_group->booking->type->name . ' ( ' .
                                            $feedback->booking_group->booking->booking_date->format('Y-m-d') . ' ' .
                                            $feedback->booking_group->booking->start_time->format('H:i') . ' )'
                                        }}
                                    </td>
                                    <td>
                                        @for ($i = 1; $i <= $feedback->rating; $i++)
                                            <i style="font-size: 10px; cursor: pointer;" class="fa fa-star fs-3 text-warning"></i>
                                        @endfor
                                    </td>
                                    <td>
                                        @for ($i = 1; $i <= $feedback->service_quality; $i++)
                                            <i style="font-size: 10px; cursor: pointer;" class="fa fa-star fs-3 text-warning"></i>
                                        @endfor
                                    </td>
                                    <td>
                                        @for ($i = 1; $i <= $feedback->staff_behavior; $i++)
                                            <i style="font-size: 10px; cursor: pointer;" class="fa fa-star fs-3 text-warning"></i>
                                        @endfor
                                    </td>
                                    <td>
                                        @for ($i = 1; $i <= $feedback->cleanliness; $i++)
                                            <i style="font-size: 10px; cursor: pointer;" class="fa fa-star fs-3 text-warning"></i>
                                        @endfor
                                    </td>
                                    <td>{{$feedback->comment}}</td>
                                    <td><span class="tag" style="background-color: {{$feedback->experience_type->color}}">{{$feedback->experience_type->name}}</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
            @else
                <p>🚫 {{__('There are no previous reviews.')}}</p>
            @endif

            <label class="block mt-4">{{__('Bookings')}}</label>
            <select wire:model="selectedTrip" class="form-control col-6" name="booking_group_id" required>
                @if($feed_back_id == null)
                <option value="">-- {{__('Select')}} --</option>
                @endif
                @foreach($trips as $trip)
                    <option value="{{ $trip->id }}">
                        {{ 
                            $trip->booking->branch->name . ' - ' .
                            __(BOOKING_TYPES[$trip->booking->booking_type])  . ' - ' .
                            $trip->booking->type->name . ' ( ' .
                            $trip->booking->booking_date->format('Y-m-d') . ' ' .
                            $trip->booking->start_time->format('H:i') . ' )'
                        }}
                    </option>
                @endforeach
            </select>

            <div class="mt-4">
                <div class="col-12 row">
                    <div class="form-group col-3">
                        <label class="form-label">⭐ {{__('Rating')}} :</label>
                        <div class="d-flex align-items-center gap-2" x-data="{ rating: @entangle('rating') || 1 }">
                            @for ($i = 1; $i <= 5; $i++)
                                <i style="font-size: 20px; cursor: pointer;" class="fa fa-star fs-3 cursor-pointer transition"
                                   :class="rating >= {{ $i }} ? 'text-warning' : 'text-secondary'"
                                   wire:click="setComponentValues('rating', {{ $i }})"
                                   x-on:click="rating = {{ $i }}"></i>
                            @endfor
                        </div>
                    </div>

                    <div class="form-group col-3">
                        <label class="form-label">🏅 {{__('Service Quality')}} :</label>
                        <div class="d-flex align-items-center gap-2" x-data="{ service_quality: @entangle('service_quality') || 1 }">
                            @for ($i = 1; $i <= 5; $i++)
                                <i style="font-size: 20px; cursor: pointer;" class="fa fa-star fs-3 cursor-pointer transition"
                                   :class="service_quality >= {{ $i }} ? 'text-warning' : 'text-secondary'"
                                   wire:click="setComponentValues('service_quality', {{ $i }})"
                                   x-on:click="service_quality = {{ $i }}"></i>
                            @endfor
                        </div>
                    </div>

                    <div class="form-group col-3">
                        <label class="form-label">👨‍✈️ {{__('Staff Behavior')}} :</label>
                        <div class="d-flex align-items-center gap-2" x-data="{ staff_behavior: @entangle('staff_behavior') || 1 }">
                            @for ($i = 1; $i <= 5; $i++)
                                <i style="font-size: 20px; cursor: pointer;" class="fa fa-star fs-3 cursor-pointer transition"
                                   :class="staff_behavior >= {{ $i }} ? 'text-warning' : 'text-secondary'"
                                   wire:click="setComponentValues('staff_behavior', {{ $i }})"
                                   x-on:click="staff_behavior = {{ $i }}"></i>
                            @endfor
                        </div>
                    </div>

                    <div class="form-group col-3">
                        <label class="form-label">🧹 {{__('Cleanliness')}}:</label>
                        <div class="d-flex align-items-center gap-2" x-data="{ cleanliness: @entangle('cleanliness') || 1 }">
                            @for ($i = 1; $i <= 5; $i++)
                                <i style="font-size: 20px; cursor: pointer;" class="fa fa-star fs-3 cursor-pointer transition"
                                   :class="cleanliness >= {{ $i }} ? 'text-warning' : 'text-secondary'"
                                   wire:click="setComponentValues('cleanliness', {{ $i }})"
                                   x-on:click="cleanliness = {{ $i }}"></i>
                            @endfor
                        </div>
                    </div>
                </div>

                <input type="hidden" value="{{$rating}}" name="rating">
                <input type="hidden" value="{{$service_quality}}" name="service_quality">
                <input type="hidden" value="{{$staff_behavior}}" name="staff_behavior">
                <input type="hidden" value="{{$cleanliness}}" name="cleanliness">
                <input type="hidden" value="{{$selectedClient->id}}" name="client_id">

                <div class="form-group col-12 mt-3">
                    <label class="form-label">🗨️ {{__('Comment')}}:</label>
                    <textarea rows="4" name="comment" wire:model="comment" class="form-control"></textarea>
                </div>

                <div class="form-group col-6 mt-3">
                    <label class="form-label">🌟 {{__('Experience Type')}} :</label>
                    <select name="experience_type_id" wire:model="experience_type_id" class="form-control" required>
                        <option value="">-- {{__('Select')}} --</option>
                        @foreach($experience_types as $oneExperience)
                            <option value="{{$oneExperience->id}}">{{$oneExperience->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @include('adminroleauthmodule::includes.save-buttons')
        </div>
    @endif
</div>
