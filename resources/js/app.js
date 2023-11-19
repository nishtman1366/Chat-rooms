import './bootstrap';

const dataWrapper = document.getElementById("data-wrapper");
const currentUserId = dataWrapper?.dataset.userId;
const currentUser = JSON.parse(dataWrapper?.dataset.user);
const channelName = dataWrapper.dataset.chatId;
const isMember = dataWrapper.dataset.userIsmember;
let userJoined = false;

function init() {
    Notification.requestPermission()
        .then((permission) => {
            if (permission === 'granted') {
                Echo.channel(`test-channel`)
                    .listen('TestWebsocketEvent', (e) => {
                        const title = e.data.title;
                        const icon = e.data.icon;
                        const body = e.data.message;
                        const notification = new Notification(title, {body, icon});
                        notification.onclick = function () {
                            window.parent.focus();
                            notification.close();
                        }
                    })
                    .error(error => console.log('channel error', error));

            }
        });
    if (JSON.parse(isMember) && !userJoined) {
        console.log('isMember', isMember);
        console.log('userJoined', userJoined);
        joinToChat(channelName, currentUserId)
    }
    const messagesContainer = document.getElementById('messages-container');
    if (messagesContainer) {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
}

window.addEventListener('load', () => init())

function addUserToList(user) {
    const usersContainer = document.getElementById('users');
    if (usersContainer) {
        const wrapper = document.createElement('div');
        wrapper.classList.add('flex', 'items-center', 'space-x-2', 'py-1');
        wrapper.id = `user-${user.id}`;
        const avatarContainer = document.createElement('div');
        const avatar = document.createElement('img');
        avatar.src = 'https://upload.wikimedia.org/wikipedia/commons/5/59/User-avatar.svg';
        avatarContainer.appendChild(avatar)
        const nameContainer = document.createElement('div');
        nameContainer.classList.add('text-sm', 'dark:text-gray-100', 'truncate');
        const name = document.createTextNode(user.name);
        nameContainer.appendChild(name);
        wrapper.appendChild(avatarContainer)
        wrapper.appendChild(nameContainer)

        usersContainer.appendChild(wrapper)
    }
}

function removeUser(user) {
    let userContainer = document.getElementById(`user-${user.id}`);
    if (userContainer) {
        userContainer.remove();
    }
}

function joinToChat(channelName, currentUserId) {
    const channel = Echo.join(`chat-room-${channelName}`)
    channel.here((users) => addUserToList({name: currentUser?.name}))
        .joining((user) => addUserToList(user))
        .leaving((user) => removeUser(user))
        .listen('ReceiveMessages', (e) => {
            const messagesContainer = document.getElementById('messages-container');
            if (messagesContainer) {
                const wrapper = document.createElement('div');
                wrapper.classList.add('flex');
                const balloon = document.createElement('div');
                balloon.classList.add('w-64', 'rounded-lg', 'p-1');
                if (parseInt(currentUserId) === parseInt(e.data.sender.id)) {
                    wrapper.classList.add('justify-end');
                    balloon.classList.add('bg-gray-300', 'dark:bg-gray-600');
                } else {
                    balloon.classList.add('bg-gray-200', 'dark:bg-gray-700');
                }
                wrapper.appendChild(balloon);
                const userBox = document.createElement('div');
                userBox.classList.add('flex', 'items-center', 'space-x-1', 'text-xs', 'dark:text-gray-300');
                userBox.appendChild(document.createTextNode(e.data?.sender?.name));
                balloon.appendChild(userBox);
                const messageBox = document.createElement('div');
                messageBox.classList.add('text-sm', 'text-gray-90', 'dark:text-gray-100');
                messageBox.appendChild(document.createTextNode(e.data?.message));
                balloon.appendChild(messageBox);

                messagesContainer.appendChild(wrapper);

                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
        })
        .subscribed(() => {
            console.log('subscribed!');
            let shadowPaper = document.getElementById('shadow-paper');
            if (shadowPaper) {
                shadowPaper.classList.add('hidden');
            }
            userJoined = true;
        })
        .listenForWhisper('typing', (e) => {
            document.getElementById('whispering').innerText = '';
            document.getElementById('whispering').innerText = `${e.name} is typing`;
            setTimeout(() => {
                document.getElementById('whispering').innerText = '';
            }, 1000)
        })
        .error(error => console.log('channel error', error));
    document.getElementById('message-box')
        .addEventListener('keydown', function (e) {
            channel.whisper('typing', {
                name: currentUser.name,
            });
        });

}

const joinChatButton = document.getElementById('join-chat-button')
joinChatButton?.addEventListener('click', (e) => {
    axios.post(`chats/${channelName}/join`)
        .then(response => {
            joinToChat(channelName, currentUserId)
        })
        .catch(error => console.log(error))
})

const logoutButton = document.getElementById('logout-button')

logoutButton?.addEventListener('click', (e) => {
    e.preventDefault();
    console.log('333')
    document.getElementById('logout-form').submit();
})

const sendButton = document.getElementById('send-button')

let message = document.getElementById('message-box')
message?.addEventListener('keydown', (e) => {
    if (e.key === 'Enter' && !e.shiftKey) {
        sendMessage(e, message)
        e.preventDefault();
        return false;
    }
})

function sendMessage(e, message) {
    if (message && message.value) {
        axios.post(`chats/${channelName}/messages/send`, {message: message.value})
            .then(response => message.value = '')
            .catch(error => console.log(error))
    }
}

sendButton?.addEventListener('click', (e) => sendMessage(e, message))

function leaveChatRoom() {
    axios.get(`chats/${channelName}/leave`)
        .then(response => window.location.reload())
        .catch(error => console.log(error))
}

const leaveChatButton = document.getElementById('leave-chat-room');
if (leaveChatButton) {
    leaveChatButton.addEventListener('click', leaveChatRoom)
}
