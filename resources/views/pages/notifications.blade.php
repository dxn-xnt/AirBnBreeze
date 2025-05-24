@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
    <x-layout.header />

    <div class="bg-[#E3EED4] min-h-screen pt-[4rem] md:pt-[7.5rem] pb-[1.5rem] sm:pb-[2rem]">
        <div class="max-w-[1750px] mx-auto px-[1rem] sm:px-[1.5rem] md:px-[2rem] lg:px-[4rem] xl:px-[8rem]">
            <!-- Showing all notifications text and Mark all as read button -->
            <div class="flex justify-between items-center mb-[1rem] sm:mb-[1.25rem]">
                <h3 class="text-[1rem] font-semibold text-airbnb-darkest mt-3">All New Notifications</h3>
                @if($notifications->count() > 0)
                    <div class="flex gap-[0.5rem]">
                        <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                            @csrf
                            <button type="submit" class="border border-airbnb-darkest text-airbnb-darkest bg-airbnb-light py-[0.375rem] px-[0.75rem] rounded-full text-[0.75rem] sm:text-[0.875rem] hover:bg-airbnb-dark hover:text-airbnb-light hover:border-airbnb-dark transition-colors duration-200 font-montserrat">
                                Mark all as read
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <!-- Notification List -->
            <div class="space-y-[0.75rem]">
                @forelse($notifications as $notification)
                        <!-- Recent Notifications -->
                        <div class="flex items-center bg-airbnb-light border border-airbnb-darkest p-[1rem] rounded-xl shadow-sm hover:shadow-md transition-all duration-200 cursor-pointer font-montserrat">
                            <img src="{{ $notification->sender->user_profile ?? asset('assets/images/MD.png') }}" alt="User" class="w-[3rem] h-[3rem] rounded-full mr-[1rem]">
                            <div class="flex-1">
                                <div class="font-semibold text-[0.875rem] sm:text-[1rem] text-airbnb-darkest">
                                        {{ $notification->notif_message }} {{ $notification->property->prop_title }}
                                </div>
                                <div class="text-[0.75rem] sm:text-[0.875rem] text-airbnb-darkest">
                                    {{ $notification->sender->user_fname }} {{ $notification->sender->user_lname }}
                                </div>
                                <div class="text-[0.625rem] sm:text-[0.75rem] text-airbnb-dark mt-[0.25rem]">
                                    @if($notification->notif_type == 'approve')
                                        Reservation Approved - Your booking request has been successfully approved
                                    @elseif($notification->notif_type == 'declined')
                                        Reservation Declined - We regret to inform you your booking request could not be approved
                                    @elseif($notification->notif_type == 'request')
                                        Reservation Request - You have received a new booking request
                                    @elseif($notification->notif_type == 'upcoming')
                                        Upcoming Reservation Notice - Your scheduled booking will begin soon
                                    @elseif($notification->notif_type == 'cancelled')
                                        Reservation Cancellation - A booking has been canceled
                                    @endif
                                </div>
                            </div>
                            <div class="text-[0.625rem] sm:text-[0.75rem] text-airbnb-dark">
                                {{ $notification->created_at->format('g:i A') }}
                            </div>
                            <form action="{{ route('notifications.delete', $notification->notif_id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ml-[1rem] text-airbnb-dark hover:text-airbnb-darkest">
                                    <i class="w-[1.25rem] h-[1.25rem]" data-lucide="x"></i>
                                </button>
                            </form>
                        </div>
                @empty
                    <div class="text-center py-8 text-airbnb-darkest font-montserrat">
                        No notifications found.
                    </div>
                @endforelse

                <div class="pt-[1rem] mt-[1rem]">
                        <h3 class="text-[0.75rem] sm:text-[0.875rem] font-semibold text-airbnb-darkest mb-[0.75rem]">Older Notifications</h3>

                        @foreach($olderNotifications as $old_notification)
                                <div class="flex items-center bg-[#E3EED4] bg-opacity-50 p-[1rem] rounded-xl mb-[0.75rem] hover:shadow-md transition-all duration-200 cursor-pointer font-montserrat">
                                    <img src="{{ $old_notification->sender->user_profile ?? asset('assets/images/MD.png') }}" alt="User" class="w-[3rem] h-[3rem] rounded-full mr-[0.75rem]">
                                    <div class="flex-1">
                                        <div class="font-semibold text-[0.875rem] sm:text-[1rem] text-airbnb-darkest">
                                            {{ $old_notification->notif_message }} {{ $old_notification->property->prop_title }}
                                        </div>
                                        <div class="text-[0.75rem] sm:text-[0.875rem] text-airbnb-darkest">
                                            {{ $old_notification->sender->user_fname }} {{ $old_notification->sender->user_lname }}
                                        </div>
                                    </div>
                                    <div class="text-[0.625rem] sm:text-[0.75rem] text-airbnb-dark">
                                        {{ $old_notification->created_at->diffForHumans() }}
                                    </div>
                                    <form action="{{ route('notifications.delete', $old_notification->notif_id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="ml-[1rem] text-airbnb-dark hover:text-airbnb-darkest">
                                            <i class="w-[1.25rem] h-[1.25rem]" data-lucide="x"></i>
                                        </button>
                                    </form>
                                </div>
                        @endforeach
                    </div>
            </div>
        </div>
    </div>
@endsection
