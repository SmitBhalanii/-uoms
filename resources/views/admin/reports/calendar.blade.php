@extends('layouts.admin')

@section('page-title', 'Orders Calendar')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item active">Orders Calendar</li>
@endsection

@push('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
<style>
#calendar {
    max-width: 1200px;
    margin: 0 auto;
}
.fc-event {
    cursor: pointer;
}
.status-legend {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
    margin-bottom: 20px;
}
.status-legend-item {
    display: flex;
    align-items: center;
    gap: 5px;
}
.status-color-box {
    width: 20px;
    height: 20px;
    border-radius: 3px;
}
</style>
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-calendar-alt"></i> Orders Calendar</h3>
    </div>
    <div class="card-body">
        <!-- Status Legend -->
        <div class="status-legend">
            <div class="status-legend-item">
                <div class="status-color-box" style="background-color: #ffc107;"></div>
                <span>Pending</span>
            </div>
            <div class="status-legend-item">
                <div class="status-color-box" style="background-color: #17a2b8;"></div>
                <span>Processing</span>
            </div>
            <div class="status-legend-item">
                <div class="status-color-box" style="background-color: #3498db;"></div>
                <span>Approved</span>
            </div>
            <div class="status-legend-item">
                <div class="status-color-box" style="background-color: #dc3545;"></div>
                <span>Rejected</span>
            </div>
            <div class="status-legend-item">
                <div class="status-color-box" style="background-color: #28a745;"></div>
                <span>Completed</span>
            </div>
        </div>

        <!-- Calendar -->
        <div id='calendar'></div>
    </div>
</div>

<!-- Order Details Modal -->
<div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderModalLabel">Order Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="orderModalBody">
                <!-- Order details will be inserted here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="#" id="viewOrderBtn" class="btn btn-primary">View Full Order</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var events = @json($events);

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        events: events,
        eventClick: function(info) {
            var props = info.event.extendedProps;
            
            var modalBody = `
                <table class="table table-bordered">
                    <tr>
                        <th>Order Number</th>
                        <td><strong>${props.order_number}</strong></td>
                    </tr>
                    <tr>
                        <th>Lab Manager</th>
                        <td>${props.user}</td>
                    </tr>
                    <tr>
                        <th>Department</th>
                        <td>${props.department}</td>
                    </tr>
                    <tr>
                        <th>Total Items</th>
                        <td>${props.total_items}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td><span class="badge" style="background-color: ${info.event.backgroundColor}">${props.status}</span></td>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <td>${info.event.start.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</td>
                    </tr>
                </table>
            `;
            
            document.getElementById('orderModalBody').innerHTML = modalBody;
            document.getElementById('viewOrderBtn').href = '/admin/orders/' + info.event.id;
            
            $('#orderModal').modal('show');
        },
        eventDidMount: function(info) {
            info.el.style.cursor = 'pointer';
        }
    });

    calendar.render();
});
</script>
@endpush
