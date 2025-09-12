OC.L10N.register('talkwidget', {
	Send: 'Send',
});

document.addEventListener('DOMContentLoaded', () => {
	const roomId = 'n3xtc10ud';

	const msgBox = document.getElementById('talk-messages');
	const input = document.getElementById('talk-message-input');
	const sendBtn = document.getElementById('talk-send-btn');
	const emojiPicker = document.getElementById('emoji-picker');

	if (!msgBox || !input || !sendBtn || !emojiPicker) return

	emojiPicker.addEventListener('change', () => {
		input.value += emojiPicker.value
		emojiPicker.value = ''
	})

	sendBtn.addEventListener('click', async () => {
		const text = input.value.trim()
		if (!text) return

		const div = document.createElement('div')
		div.innerHTML = `<strong>You:</strong> ${text}`
		div.style.marginBottom = '8px'
		msgBox.appendChild(div)
		msgBox.scrollTop = msgBox.scrollHeight
		input.value = ''

		try {
			await fetch(`/apps/talkwidget/api/send`, {
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify({ roomId, message: text }),
			})
		} catch (e) {
			console.error('Failed to send message', e)
		}
	})

	async function fetchMessages() {
		try {
			const response = await fetch(`/apps/talkwidget/api/messages?roomId=${roomId}`)
			const messages = await response.json()
			msgBox.innerHTML = ''
			messages.forEach(msg => {
				const div = document.createElement('div')
				div.innerHTML = `<strong>${msg.id}:</strong> ${msg.message}`
				div.style.marginBottom = '8px'
				msgBox.appendChild(div)
			})
			msgBox.scrollTop = msgBox.scrollHeight
		} catch (e) {
			console.error('Failed to fetch messages', e)
		}
	}

	fetchMessages()
	setInterval(fetchMessages, 5000)
})
