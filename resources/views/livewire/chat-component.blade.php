<div>
    <div style="overscroll-behavior: none;">
        <!-- Header -->
        <div class="fixed w-full bg-green-600 h-16 pt-2 text-white flex justify-between shadow-md"
            style="top:0px; overscroll-behavior: none;">
            <!-- Back button -->
            <a href="{{ route('dashboard') }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-8 h-8 my-4 ml-4 text-white">
                    <path class="text-white fill-current"
                        d="M9.41 11H17a1 1 0 0 1 0 2H9.41l2.3 2.3a1 1 0 1 1-1.42 1.4l-4-4a1 1 0 0 1 0-1.4l4-4a1 1 0 0 1 1.42 1.4L9.4 11z" />
                </svg>
            </a>
            <div class="my-4 font-bold text-lg">{{ $user->name }}</div>
            <!-- 3 dots -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="icon-dots-vertical w-6 h-6 mt-5 mr-4">
                <path class="text-white fill-current" fill-rule="evenodd"
                    d="M12 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4z" />
            </svg>
        </div>

        <!-- Chat messages -->
        <div class="mt-20 mb-20">
            @foreach ($messages as $msg)
                @if ($msg['sender'] != auth()->user()->name)
                    <!-- Incoming message -->
                    <div class="clearfix w-4/4">
                        <div class="bg-gray-200 text-black inline-block mx-4 my-2 p-3 rounded-lg rounded-tl-none shadow-md">
                            <b>{{ $msg['sender'] }} :</b> {{ $msg['message'] }}
                        </div>
                    </div>
                @else
                    <!-- Outgoing message -->
                    <div class="clearfix w-4/4">
                        <div class="text-right">
                            <p class="bg-green-300 text-black inline-block mx-4 my-2 p-3 rounded-lg rounded-tr-none shadow-md">
                                <b>You: </b>{{ $msg['message'] }}
                            </p>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <!-- Message input -->
    <form wire:submit.prevent="sendMessage()">
        <div class="fixed w-full flex justify-between bg-white" style="bottom: 0px;">
            <textarea class="flex-grow m-2 py-2 px-4 mr-1 rounded-2xl border border-gray-300 bg-gray-100 resize-none shadow-inner"
                rows="1" placeholder="Message..." wire:model="message" style="outline: none;"></textarea>
            <button type="submit" class="m-2" style="outline: none;">
                <svg class="text-green-600 w-8 h-8 py-2 mr-3" aria-hidden="true" focusable="false" data-prefix="fas"
                    data-icon="paper-plane" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path fill="currentColor"
                        d="M476 3.2L12.5 270.6c-18.1 10.4-15.8 35.6 2.2 43.2L121 358.4l287.3-253.2c5.5-4.9 13.3 2.6 8.6 8.3L176 407v80.5c0 23.6 28.5 32.9 42.5 15.8L282 426l124.6 52.2c14.2 6 30.4-2.9 33-18.2l72-432C515 7.8 493.3-6.8 476 3.2z" />
                </svg>
            </button>
        </div>
    </form>
</div>
