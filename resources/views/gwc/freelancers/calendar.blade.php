@extends('gwc.template.indexTemplate' , ['searchBox' => false])
@section('style')
    <link href='{{asset('admin_assets/FullCalendar/main.css')}}' rel='stylesheet' />
    <script src='{{asset('admin_assets/FullCalendar/main.js')}}'></script>
@endsection
@section('indexContent')
    <div id='calendar'></div>

@stop

@section('script')
    <script>

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                navLinks: true, // can click day/week names to navigate views
                selectable: false,
                selectMirror: true,
                select: function(arg) {
                    var title = prompt('Event Title:');
                    if (title) {
                        calendar.addEvent({
                            title: title,
                            start: arg.start,
                            end: arg.end,
                            allDay: arg.allDay
                        })
                    }
                    calendar.unselect()
                },
                eventClick: function(arg) {
                    // if (confirm('Are you sure you want to delete this event?')) {
                    //     arg.event.remove()
                    // }
                    console.log(arg.event);
                },
                editable: false,
                dayMaxEvents: true, // allow "more" link when too many events
                events: [
                    @foreach($resources as $resource )
                        {
                            title: '{{ $resource['resource']['type'] }}: {{ $resource['resource']['name'] }}',
                            start: '{{ $resource['resource']['date'] }}T{{ $resource['resource']['time'] }}',
                        },
                    @endforeach
                ]
            });

            calendar.render();
        });

    </script>
@endsection