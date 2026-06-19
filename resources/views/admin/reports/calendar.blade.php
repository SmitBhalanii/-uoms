@extends('layouts.admin')

@section('page-title', 'Orders Calendar')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item active">Orders Calendar</li>
@endsection

@push('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
<style>
/* Scope FullCalendar styles to calendar page only */
.fc {
    /* FullCalendar styles scoped */
}
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
/* Prevent FullCalendar CSS from affecting other pages */
.fc-direction-ltr .fc-button-group > .fc-button:not(:first-child) {
    margin-left: 0;
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

<!-- Order Details Modal (Bootstrap 5) -->
<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderModalLabel">Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="orderModalBody">
                <!-- Order details will be inserted here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="#" id="viewOrderBtn" class="btn btn-primary" target="_blank">View Full Order</a>
            </div>
        </div>
    </div>
</div>

<!-- Date Orders Modal (Bootstrap 5) -->
<div class="modal fade" id="dateOrdersModal" tabindex="-1" aria-labelledby="dateOrdersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dateOrdersModalLabel">Orders on <span id="selectedDate"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="dateOrdersModalBody">
                <!-- Date orders will be inserted here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
    var orderModal;
    var dateOrdersModal;

    // Initialize Bootstrap 5 modals
    if (typeof bootstrap !== 'undefined') {
        orderModal = new bootstrap.Modal(document.getElementById('orderModal'));
        dateOrdersModal = new bootstrap.Modal(document.getElementById('dateOrdersModal'));
    }

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,dayGridWeek,listMonth'
        },
        views: {
            dayGridMonth: {
                titleFormat: { year: 'numeric', month: 'long' }
            },
            dayGridWeek: {
                titleFormat: { year: 'numeric', month: 'short', day: 'numeric' }
            },
            listMonth: {
                titleFormat: { year: 'numeric', month: 'long' }
            }
        },
        events: events,
        eventClick: function(info) {
            info.jsEvent.preventDefault();
            var props = info.event.extendedProps;
            
            var modalBody = `
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 150px;">Order Number</th>
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
                        <td><span class="badge" style="background-color: ${info.event.backgroundColor}; color: white;">${props.status}</span></td>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <td>${info.event.start.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</td>
                    </tr>
                </table>
            `;
            
            document.getElementById('orderModalBody').innerHTML = modalBody;
            document.getElementById('viewOrderBtn').href = '/admin/orders/' + info.event.id;
            
            if (orderModal) {
                orderModal.show();
            }
        },
        dateClick: function(info) {
            var clickedDate = info.dateStr;
            var dateOrders = events.filter(function(event) {
                return event.start === clickedDate;
            });

            if (dateOrders.length === 0) {
                alert('No orders on this date');
                return;
            }

            var formattedDate = new Date(clickedDate).toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });

            document.getElementById('selectedDate').innerText = formattedDate;

            var tableHtml = `
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Order Number</th>
                                <th>Lab Manager</th>
                                <th>Department</th>
                                <th>Total Items</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

            dateOrders.forEach(function(order) {
                tableHtml += `
                    <tr>
                        <td><strong>${order.extendedProps.order_number}</strong></td>
                        <td>${order.extendedProps.user}</td>
                        <td>${order.extendedProps.department}</td>
                        <td>${order.extendedProps.total_items}</td>
                        <td><span class="badge" style="background-color: ${order.backgroundColor}; color: white;">${order.extendedProps.status}</span></td>
                        <td>
                            <a href="/admin/orders/${order.id}" class="btn btn-sm btn-info" target="_blank">
                                <i class="fas fa-eye"></i> View
                            </a>
                        </td>
                    </tr>
                `;
            });

            tableHtml += `
                        </tbody>
                    </table>
                </div>
            `;

            document.getElementById('dateOrdersModalBody').innerHTML = tableHtml;

            if (dateOrdersModal) {
                dateOrdersModal.show();
            }
        },
        eventDidMount: function(info) {
            info.el.style.cursor = 'pointer';
        },
        // Date-based calendar settings
        allDaySlot: true,
        eventDisplay: 'block'
    });

    calendar.render();
});
</script>
@endpush
