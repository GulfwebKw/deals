<div class="flex-lg-row-fluid ms-lg-7 ms-xl-10" id="list_of_all_message">
    <!--begin::Messenger-->
    <div class="card" id="kt_chat_messenger">
        <!--begin::Card header-->
        <div class="card-header" id="kt_chat_messenger_header">
            <!--begin::Title-->
            <div class="card-title">
                <!--begin::User-->
                <div class="d-flex justify-content-center flex-column me-3">
                    <a href="#"
                       class="fs-4 fw-bolder text-gray-900 text-hover-primary me-1 mb-2 lh-1">{{$resources[0]['user']->first_name . ' '.$resources[0]['user']->last_name }}</a>
                </div>
                <!--end::User-->
            </div>
            <!--end::Title-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body" id="kt_chat_messenger_body"
             style="overflow: auto;height: calc(100vh - 322px) !important;">
        @foreach($resources as $key=>$comment)
            @if($comment->type=='user')
                <!--begin::Messages-->
                    <div class="scroll-y me-n5 pe-5 h-300px h-lg-auto" data-kt-element="messages" data-kt-scroll="true"
                         data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                         data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_chat_messenger_header, #kt_chat_messenger_footer"
                         data-kt-scroll-wrappers="#kt_content, #kt_chat_messenger_body" data-kt-scroll-offset="5px">
                        <!--begin::Message(in)-->
                        <div class="d-flex justify-content-end mb-10">
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-column align-items-end">
                                <!--begin::User-->
                                <div class="d-flex align-items-center mb-2">
                                    <!--begin::Details-->
                                    <div class="ms-3">
                                        <span class="text-muted fs-7 mb-1"
                                              title="{{$comment->created_at}}">{{ Carbon\Carbon::parse($comment->created_at)->diffForHumans(Carbon\Carbon::now()) }}</span>
                                        <a href="#"
                                           class="fs-5 fw-bolder text-gray-900 text-hover-primary me-1">{{$comment['user']->first_name . ' '. $comment['user']->last_name}}</a>
                                    </div>
                                    <!--end::Details-->
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-35px symbol-circle">
                                        <img alt="Pic" src="{{$comment['user']->image}}"/>
                                    </div>
                                    <!--end::Avatar-->
                                </div>
                                <!--end::User-->
                                <!--begin::Text-->
                                <div class="p-5 rounded bg-light-info text-dark fw-bold mw-lg-400px text-start"
                                     data-kt-element="message-text"
                                     @if($comment->lat!=null && $comment->long!=null) id="{{'mapid'.$key}}"
                                     style="height: 250px;width: 100vw;" @endif>
                                    @if($comment->message!=null)
                                        @if ( $comment->message_type == 7  )
                                            <a href="/gwc/bills?id={{$comment->message}}" target="_blank" style="margin: 20px"><b>BILL</b></a>
                                        @elseif ( $comment->message_type == 6 and  $comment->type == 'freelancer')
                                            <a href="#" onclick="openQuotation('/gwc/freelancers/{{$comment->freelancer_id}}/quotation/{{$comment->message}}');" style="margin: 20px"><b>Full Quotation</b></a>
                                        @else
                                            {!!html_entity_decode($comment->message)!!}
                                        @endif
                                    @endif
                                    @if($comment->lat!=null && $comment->long!=null)
                                        <script>

                                            var token = 'pk.eyJ1Ijoic29oZWlsdmFpbyIsImEiOiJja2kxcnUyYTUwNW03MnhudDNsOGRwNG94In0.h3EW-3gLt4EccaIq9tImIw';
                                            var lat = '{{$comment->lat}}'
                                            var long = '{{$comment->long}}'
                                            var sender = L.map({{'mapid'.$key}}).setView([lat, long], 15);
                                            var markersender = L.marker([lat, long]).addTo(sender);

                                            // markersender.bindPopup("<b>ویلا</b>").openPopup();

                                            L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                                                attribution: '{{ websiteName() }}',
                                                maxZoom: 18,
                                                id: 'mapbox/streets-v11',
                                                tileSize: 512,
                                                zoomOffset: -1,
                                                accessToken: token
                                            }).addTo(sender);
                                        </script>

                                    @endif
                                    @if($comment->file!=null)
                                        <a href="{{route('message.download', $comment->id)}}" style="margin: 20px"><b>DOWNLOAD</b></a>
                                    @endif
                                </div>
                                <!--end::Text-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Message(in)-->
                    </div>
            @else
                        <!--begin::Message(out)-->
                            <div class="d-flex justify-content-start mb-10">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-column align-items-start">
                                    <!--begin::User-->
                                    <div class="d-flex align-items-center mb-2">
                                        <!--begin::Avatar-->
                                        <div class="symbol symbol-35px symbol-circle">
                                            <img alt="Pic" src="{{$comment['freelancer']->image}}"/>
                                        </div>
                                        <!--end::Avatar-->
                                        <!--begin::Details-->
                                        <div class="me-3">
                                            <a href="#"
                                               class="fs-5 fw-bolder text-gray-900 text-hover-primary ms-1">{{$comment['freelancer']->name}}</a>
                                            <span class="text-muted fs-7 mb-1"
                                                  title="{{$comment->created_at}}">{{ Carbon\Carbon::parse($comment->created_at)->diffForHumans(Carbon\Carbon::now()) }}</span>
                                        </div>
                                        <!--end::Details-->
                                    </div>
                                    <!--end::User-->
                                    <!--begin::Text-->
                                    <div class="p-5 rounded bg-light-primary text-dark fw-bold mw-lg-400px text-end"
                                         data-kt-element="message-text"
                                         @if($comment->lat!=null && $comment->long!=null) id="{{'mapid'.$key}}"
                                         style="height: 250px;width: 100vw;" @endif>
                                        @if($comment->message!=null)
                                            @if ( $comment->message_type == 7  )
                                                <a href="/gwc/bills?id={{$comment->message}}" target="_blank" style="margin: 20px"><b>BILL</b></a>
                                            @elseif ( $comment->message_type == 6 and  $comment->type == 'freelancer')
                                                <a href="#" onclick="openQuotation('/gwc/freelancers/{{$comment->freelancer_id}}/quotation/{{$comment->message}}');" style="margin: 20px"><b>Full Quotation</b></a>                                            @else
                                                {!!html_entity_decode($comment->message)!!}
                                            @endif
                                        @endif
                                        @if($comment->lat!=null && $comment->long!=null)
                                            <script>

                                                var token = 'pk.eyJ1Ijoic29oZWlsdmFpbyIsImEiOiJja2kxcnUyYTUwNW03MnhudDNsOGRwNG94In0.h3EW-3gLt4EccaIq9tImIw';
                                                var lat = '{{$comment->lat}}'
                                                var long = '{{$comment->long}}'
                                                var sender = L.map({{'mapid'.$key}}).setView([lat, long], 15);
                                                var markersender = L.marker([lat, long]).addTo(sender);

                                                // markersender.bindPopup("<b>ویلا</b>").openPopup();

                                                L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                                                    attribution: '{{ websiteName() }}',
                                                    maxZoom: 18,
                                                    id: 'mapbox/streets-v11',
                                                    tileSize: 512,
                                                    zoomOffset: -1,
                                                    accessToken: token
                                                }).addTo(sender);
                                            </script>
                                        @endif
                                        @if($comment->file!=null)
                                            <a href="{{route('message.download', $comment->id)}}"
                                               style="margin: 20px"><b>DOWNLOAD</b></a>
                                        @endif
                                    </div>
                                    <!--end::Text-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Message(out)-->
                        @endif

                        @endforeach
                    </div>
                    <!--end::Messages-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Messenger-->
</div>