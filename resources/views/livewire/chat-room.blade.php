<div
    class="mt-4 bg-white rounded-lg shadow-md p-6"
    x-data="{{ json_encode(['messages' => $messages, 'messageBody' => '']) }}"
    x-init="
            Echo.join('demo')
                .listen('MessageSentEvent', (e) => {
                    @this.call('incomingMessage', e)
                })
            ">

    <div class="flex flex-row flex-wrap border-b">
        <div class="text-gray-600 w-full mb-4">Members:</div>

        @forelse($here as $authData)
            <div class="px-2 py-1 text-white bg-blue-700 rounded mr-4 mb-4">
                {{ $authData['name'] }}
            </div>
        @empty
            <div class="py-4 text-gray-600">
                It's quiet in here...
            </div>
        @endforelse
    </div>

    <template x-if="messages.length > 0">
        <template
            x-for="message in messages"
            :key="message.id"
        >
            <div class="my-8">
                <div class="flex flex-row justify-between border-b border-gray-200">
                    <span class="text-gray-600" x-text="message.user.name"></span>
                    <span class="text-gray-500 text-xs" x-text="message.created_at"></span>
                </div>
                <div class="my-4 text-gray-800" x-text="message.body"></div>
            </div>
        </template>
    </template>

    <template x-if="messages.length == 0">
        <div class="py-4 text-gray-600">
            It's quiet in here...
        </div>
    </template>

    <div
        class="flex flex-row justify-between"
    >
        <input
            @keydown.enter="
                @this.call('sendMessage', messageBody)
                messageBody = ''
            "
            x-model="messageBody"
            class="mr-4 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="text"
            placeholder="Hello World!">

        <button
            @click="
                @this.call('sendMessage', messageBody)
                messageBody = ''
            "
            class="btn btn-primary self-stretch"
        >
            Send
        </button>
    </div>
    @error('messageBody') <div class="error mt-2">{{ $message }}</div> @enderror
</div>
