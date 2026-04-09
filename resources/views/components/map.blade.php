<div class="location section map" id="location">
    <div class="location__traffic">
        <div class="location__traffic-checkbox">
            <label class="traffic-checkbox">
                <input class="traffic-checkbox__checkbox transport" type="checkbox" checked="checked" />
                <span class="traffic-checkbox__view"></span>
            </label>
        </div>
        <div class="location__traffic-title">Транспортная доступность</div>
    </div>
    <div class="location__sidebar init-animation">
        <div class="location__tabs">
            <div class="tabs-controls tabs-controls--location tabs">
                @foreach($mapCategories as $mapCategory)
                    <a class="tabs-controls__item"
                        {{ $loop->first ? 'id=map-init' : ''}}
                        data-index="{{ $loop->iteration }}"
                    >
                        {{ $mapCategory->name }}
                    </a>
                @endforeach
            </div>
        </div>
        <div class="location__inner">
            <div class="location__inner-items">

                @foreach($mapCategories as $mapCategory)
                    <?php $pinNum = 0; ?>
                    <div class="location__pane location-pane--places tab-content {{ $loop->first ? 'is-active' : '' }}"
                         data-index="{{ $loop->iteration }}"
                    >
                        @foreach($mapCategory->mapSubcategories as $subcategory)
                            <div class="map-group">
                                <div class="map-group__top">
                                    <div class="map-group__top-title">{{ $subcategory->name }}</div>
                                    <div class="map-group__top-icon"></div>
                                </div>
                                <div class="map-group__inner"  {{ $loop->first ? 'style=display:block' : '' }}>
                                    @foreach($subcategory->MapMarkers as $marker)
                                        <div class="map-item" data-pin="{{ $pinNum }}">

                                            <div class="map-item__top">
                                                <div class="map-item__top-counter">{{ $pinNum + 1 }}</div>
                                                <div class="map-item__top-title">{{ $marker->name }}</div>
                                                <img class="map-item__top-arrow" src="/img/arrow-b.svg" alt=""/>
                                            </div>

                                            <div class="map-item__inner">

                                                @if(!empty( $marker->image ))
                                                    <img class="map-item__image" src="{{ $marker->image }}"
                                                         srcset="{{ $marker->image }}" alt="{{ $marker->name }}"/>
                                                @endif

                                                <div class="map-item__location">{{ $marker->address }}</div>
                                                <div class="map-item__info">
                                                    <div class="map-item__info-item">
                                                        <div class="map-item__info-title">{{ $marker->distance }} м</div>
                                                    </div>
                                                    <div class="map-item__info-item">

                                                        @if($marker->transport == 0)
                                                            <img class="map-item__info-icon" src="/img/walk.png" alt="Пешком"/>
                                                        @else
                                                            <img class="map-item__info-icon" src="/img/car.svg" alt="На авто"/>
                                                        @endif

                                                        <div class="map-item__info-title">{{ $marker->time }} мин</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php $pinNum++; ?>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                        @foreach($mapCategory->MapMarkers as $marker)
                            @if($marker->map_subcategory_id == null)
                                <div class="map-item" data-pin="{{ $pinNum }}">

                                    <div class="map-item__top">
                                        <div class="map-item__top-counter">{{ $pinNum + 1 }}</div>
                                        <div class="map-item__top-title">{{ $marker->name }}</div>
                                        <img class="map-item__top-arrow" src="/img/arrow-b.svg" alt=""/>
                                    </div>

                                    <div class="map-item__inner">

                                        @if(!empty( $marker->image ))
                                            <img class="map-item__image" src="{{ $marker->image }}"
                                                 srcset="{{ $marker->image }}" alt="{{ $marker->name }}"/>
                                        @endif

                                        <div class="map-item__location">{{ $marker->address }}</div>
                                        <div class="map-item__info">
                                            <div class="map-item__info-item">
                                                <div class="map-item__info-title">{{ $marker->distance }} м</div>
                                            </div>
                                            <div class="map-item__info-item">

                                                @if($marker->transport == 0)
                                                    <img class="map-item__info-icon" src="/img/walk.png" alt="Пешком"/>
                                                @else
                                                    <img class="map-item__info-icon" src="/img/car.svg" alt="На авто"/>
                                                @endif

                                                <div class="map-item__info-title">{{ $marker->time }} мин</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php $pinNum++; ?>
                            @endif
                        @endforeach
                    </div>
                @endforeach

            </div>
        </div>
        <a class="btn btn--green mt25" href="{{ route('blocks-list') }}">Выбрать квартиру</a>
    </div>
    <div class="location__map" id="map">Map here</div>
</div>

@push('footer_scripts')
    <script>

        function myMap() {
            var lineSymbol = {
                path: 'M 0,-0.1 0,01',
                strokeOpacity: 1,
                scale: 2.1
            };

            var startLat = 55.721225;
            var startLng = 37.605303;

            var mapCanvas = document.getElementById('map');
            var mapOptions = {
                panControl: false,
                zoomControl: false,
                mapTypeControl: false,
                scaleControl: true,
                streetViewControl: false,
                overviewMapControl: false,
                rotateControl: false,
                styles: [
                    {
                        featureType: 'administrative.land_parcel',
                        elementType: 'labels',
                        stylers: [
                            {
                                visibility: 'off'
                            }
                        ]
                    },
                    {
                        featureType: 'poi',
                        elementType: 'labels.icon',
                        stylers: [
                            {
                                visibility: 'off'
                            }
                        ]
                    },
                    {
                        featureType: 'poi',
                        elementType: 'labels.text',
                        stylers: [
                            {
                                visibility: 'off'
                            }
                        ]
                    },
                    {
                        featureType: 'poi.business',
                        stylers: [
                            {
                                visibility: 'off'
                            }
                        ]
                    },
                    {
                        featureType: 'road',
                        elementType: 'labels.icon',
                        stylers: [
                            {
                                visibility: 'off'
                            }
                        ]
                    },
                    {
                        featureType: 'road.local',
                        elementType: 'geometry',
                        stylers: [
                            {
                                visibility: 'off'
                            }
                        ]
                    },
                    {
                        featureType: 'road.local',
                        elementType: 'labels',
                        stylers: [
                            {
                                visibility: 'off'
                            }
                        ]
                    },
                    {
                        featureType: 'road',
                        elementType: 'geometry.fill',
                        stylers: [
                            {
                                color: '#F89A7F'
                            }
                        ]
                    },
                    {
                        featureType: 'transit',
                        stylers: [
                            {
                                visibility: 'on'
                            }
                        ]
                    }
                ]
            };
            var mapOptionsWithoutRoads = {
                styles: [
                    {
                        featureType: 'administrative.land_parcel',
                        elementType: 'labels',
                        stylers: [
                            {
                                visibility: 'off'
                            }
                        ]
                    },
                    {
                        featureType: 'poi',
                        elementType: 'labels.icon',
                        stylers: [
                            {
                                visibility: 'off'
                            }
                        ]
                    },
                    {
                        featureType: 'poi',
                        elementType: 'labels.text',
                        stylers: [
                            {
                                visibility: 'off'
                            }
                        ]
                    },
                    {
                        featureType: 'poi.business',
                        stylers: [
                            {
                                visibility: 'off'
                            }
                        ]
                    },
                    {
                        featureType: 'road',
                        elementType: 'labels.icon',
                        stylers: [
                            {
                                visibility: 'off'
                            }
                        ]
                    },
                    {
                        featureType: 'road.local',
                        elementType: 'geometry',
                        stylers: [
                            {
                                visibility: 'off'
                            }
                        ]
                    },
                    {
                        featureType: 'road.local',
                        elementType: 'labels',
                        stylers: [
                            {
                                visibility: 'off'
                            }
                        ]
                    },
                    {
                        featureType: 'transit',
                        stylers: [
                            {
                                visibility: 'on'
                            }
                        ]
                    }
                ]
            };

            var map = new google.maps.Map(mapCanvas, mapOptions);
            map.setCenter(new google.maps.LatLng(startLat, startLng));
            map.setZoom(15);

            var markers = [];
            var activeIcon = {
                url: '/img/pin_active.png',
                anchor: new google.maps.Point(20, 22)
            };

            var path = undefined;

            var normalIcon = {
                url: '/img/pin.png',
                anchor: new google.maps.Point(16, 16)
            };

            /*Пины табов*/
            @foreach($mapCategories as $mapCategory)
                var locations_{{ $loop->iteration }} = [
                    @foreach($mapCategory->MapMarkers as $mapMarker)
                        ["{{ $loop->iteration }}", {{ $mapMarker->lat }}, {{ $mapMarker->lon }}, {!! $loop->first ? "'pin_active'" : "'pin'" !!}],
                    @endforeach
                ];
            @endforeach


            /*Пути для пинов*/
                    @foreach($mapCategories as $mapCategory)
            var paths_{{ $loop->iteration }} = [
                            @foreach($mapCategory->MapMarkers as $mapMarker)
                    [
                        '{{ $loop->iteration }}',
                        [{ lat: startLat, lng: startLng }, { lat: {{ $mapMarker->lat }}, lng: {{ $mapMarker->lon }} }]
                    ],
                        @endforeach
                ];
            @endforeach

            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(startLat, startLng),
                icon: '/img/house.png',
                map: map
            });
            var oldPin = 0;

            function setMapOnAll(map) {
                for (var i = 0; i < markers.length; i++) {
                    markers[i].setMap(map);
                }
            }

            var listener = null;

            // Click on tab

            $('.map .tabs a').on('click', function(e) {
                e.preventDefault();

                if (path !== undefined) {
                    path.setMap(null);
                }

                // Remove controls if small screen ???

                if ($(this).hasClass('is-active')) {
                    $(this).removeClass('is-active');
                    if ($(window).width() < 768) {
                        $('.map .tab-content').slideUp();
                        setMapOnAll(null);
                        return false;
                    }
                }

                google.maps.event.removeListener(listener);
                $('.map .tabs a').removeClass('is-active');
                $(this).addClass('is-active');
                $('.map .tab-content').hide();

                if ($(window).width() < 768) {
                    $(
                        '.map .tab-content[data-index="' + $(this).data('index') + '"]'
                    ).slideDown();
                } else {
                    $('.map .tab-content[data-index="' + $(this).data('index') + '"]').show();
                }

                // Show initial tab

                let initialTab = $(
                    '.map .tab-content[data-index="' +
                    $(this).data('index') +
                    '"] .map-item[data-pin="0"]'
                );

                mapItemExpand(initialTab);

                setMapOnAll(null);
                markers = [];

                // Tab group 1

                if ($(this).data('index') === 1) {
                    for (i = 0; i < locations_1.length; i++) {
                        if (i === 0) {
                            var icon = activeIcon;
                        } else {
                            var icon = normalIcon;
                        }

                        marker = new google.maps.Marker({
                            position: new google.maps.LatLng(
                                locations_1[i][1],
                                locations_1[i][2]
                            ),
                            map: map,
                            icon: icon,
                            label: locations_1[i][0]
                        });

                        if (i === 0) {
                            path = new google.maps.Polyline({
                                path: paths_1[i][1],
                                geodesic: true,
                                strokeColor: '#F57049',
                                strokeOpacity: 0,
                                strokeWeight: 3,
                                icons: [
                                    {
                                        icon: lineSymbol,
                                        offset: '0',
                                        repeat: '10px'
                                    }
                                ]
                            });
                            path.setMap(map);
                        }

                        markers.push(marker);
                        var listener = google.maps.event.addListener(
                            marker,
                            'click',
                            (function(marker, i) {
                                return function() {
                                    path.setMap(null);
                                    for (var j = 0; j < markers.length; j++) {
                                        markers[j].setIcon(normalIcon);
                                    }
                                    this.setIcon(activeIcon);
                                    path = new google.maps.Polyline({
                                        path: paths_1[i][1],
                                        geodesic: true,
                                        strokeColor: '#F57049',
                                        strokeOpacity: 0,
                                        strokeWeight: 3,
                                        icons: [
                                            {
                                                icon: lineSymbol,
                                                offset: '0',
                                                repeat: '10px'
                                            }
                                        ]
                                    });
                                    path.setMap(map);

                                    console.log('click');

                                    var _link = $('body .map-item[data-pin="' + i + '"]');
                                    //_link.trigger('click'); // Double click
                                    mapItemExpand(_link);

                                    map.panTo(marker.getPosition());
                                };
                            })(marker, i)
                        );
                    }

                    // Tab group 2
                } else {
                    for (var i = 0; i < locations_2.length; i++) {
                        if (i === 0) {
                            var icon = activeIcon;
                        } else {
                            var icon = normalIcon;
                        }

                        marker = new google.maps.Marker({
                            position: new google.maps.LatLng(
                                locations_2[i][1],
                                locations_2[i][2]
                            ),
                            map: map,
                            icon: icon,
                            label: locations_2[i][0]
                        });

                        if (i === 0) {
                            path = new google.maps.Polyline({
                                path: paths_2[i][1],
                                geodesic: true,
                                strokeColor: '#F57049',
                                strokeOpacity: 0,
                                strokeWeight: 3,
                                icons: [
                                    {
                                        icon: lineSymbol,
                                        offset: '0',
                                        repeat: '10px'
                                    }
                                ]
                            });
                            path.setMap(map);
                        }

                        markers.push(marker);
                        var listener = google.maps.event.addListener(
                            marker,
                            'click',
                            (function(marker, i) {
                                return function() {
                                    path.setMap(null);
                                    for (var j = 0; j < markers.length; j++) {
                                        markers[j].setIcon(normalIcon);
                                    }
                                    this.setIcon(activeIcon);
                                    path = new google.maps.Polyline({
                                        path: paths_2[i][1],
                                        geodesic: true,
                                        strokeColor: '#F57049',
                                        strokeOpacity: 0,
                                        strokeWeight: 3,
                                        icons: [
                                            {
                                                icon: lineSymbol,
                                                offset: '0',
                                                repeat: '10px'
                                            }
                                        ]
                                    });
                                    path.setMap(map);

                                    console.log('click');

                                    var _link = $('body .map-item[data-pin="' + i + '"]');

                                    mapItemExpand(_link);

                                    map.panTo(marker.getPosition());
                                };
                            })(marker, i)
                        );
                    }
                }
            });

            // Expand item

            function mapItemExpand(element) {
                if (element.hasClass('is-active')) {
                    // Already active, hide

                    element
                        .removeClass('is-active')
                        .find('.map-item__inner')
                        .slideUp();
                } else {
                    // Not active, expand

                    const parentPanel = element.closest('.map-group');

                    if (parentPanel) {
                        expandGroup(parentPanel);
                    }

                    // Close already active tabs

                    $('.map-item')
                        .removeClass('is-active')
                        .find('.map-item__inner')
                        .slideUp();

                    element
                        .addClass('is-active')
                        .find('.map-item__inner')
                        .slideDown();
                }
            }

            // Map group

            $('.map-group__top').on('click', function() {
                const parent = $(this).parent();

                if (parent.hasClass('is-active')) {
                    parent
                        .removeClass('is-active')
                        .find('.map-group__inner')
                        .slideUp();
                } else {
                    $('.map-group')
                        .removeClass('is-active')
                        .find('.map-group__inner')
                        .slideUp();

                    parent
                        .addClass('is-active')
                        .find('.map-group__inner')
                        .slideDown();
                }
            });

            // Click on map item

            $('body').on('click', '.map-item', function(e) {
                if (e.originalEvent !== undefined) {
                    new google.maps.event.trigger(markers[$(this).data('pin')], 'click');
                }
            });

            // Map tabs

            function expandGroup(element) {
                element
                    .addClass('is-active')
                    .find('.map-group__inner')
                    .slideDown();
            }

            $('body').on('change', '.transport', function() {
                $('.transport').prop('checked', $(this).prop('checked'));
                $(this).is(':checked')
                    ? map.setOptions(mapOptions)
                    : map.setOptions(mapOptionsWithoutRoads);
            });

            // Init map

            $('#map-init').trigger('click');
        }
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD98ai0Ml4grGL4GpkDyU8SeAqwNF9545I&callback=myMap"></script>
@endpush