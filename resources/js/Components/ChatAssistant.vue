<script setup>
import { Bot, Info, Minus, Paperclip, Send, User, X } from 'lucide-vue-next';
import { nextTick, ref } from 'vue';

defineProps({
    isOpen: Boolean
});

defineEmits(['toggle-chat']);

const messages = ref([
    {
        sender: 'ai',
        text: "Hello! 👋 Welcome to ElectroHub.\nI'm your AI shopping assistant. How can I help you today?",
        image: null
    }
]);

const userInput = ref('');
const selectedImageFile = ref(null);
const selectedImageBase64 = ref(null);
const isTyping = ref(false);
const chatMessagesContainer = ref(null);

const scrollToBottom = async () => {
    await nextTick();
    if (chatMessagesContainer.value) {
        chatMessagesContainer.value.scrollTop = chatMessagesContainer.value.scrollHeight;
    }
};

const previewImage = (event) => {
    const file = event.target.files[0];
    if (!file) return;

    if (!['image/jpeg', 'image/png', 'image/webp', 'image/jpg'].includes(file.type)) {
        alert('Please upload a valid image file (JPG, PNG, WEBP).');
        return;
    }
    if (file.size > 5 * 1024 * 1024) {
        alert('File size exceeds 5MB limit.');
        return;
    }

    selectedImageFile.value = file;
    const reader = new FileReader();
    reader.onload = (e) => {
        selectedImageBase64.value = e.target.result;
    };
    reader.readAsDataURL(file);
};

const removeImage = () => {
    selectedImageFile.value = null;
    selectedImageBase64.value = null;
};

const sendMessage = async (textPrompt = null) => {
    const text = textPrompt || userInput.value.trim();
    const image = selectedImageBase64.value;

    if (!text && !image) return;

    // Add user message
    messages.value.push({
        sender: 'user',
        text: text,
        image: image
    });

    userInput.value = '';
    removeImage();
    scrollToBottom();

    // Show typing indicator
    isTyping.value = true;
    scrollToBottom();

    try {
        // Laravel AI SDK Integration Endpoint Prep
        const aiResponse = await sendToLaravelAI(text, image);
        isTyping.value = false;
        messages.value.push({
            sender: 'ai',
            text: aiResponse,
            image: null
        });
        scrollToBottom();
    } catch (error) {
        isTyping.value = false;
        messages.value.push({
            sender: 'ai',
            text: "Sorry, I encountered an issue connecting to the AI assistant service.",
            image: null
        });
        scrollToBottom();
    }
};

// Laravel AI SDK API Hook
const sendToLaravelAI = async (message, image) => {
    const formData = new FormData();
    if (message) formData.append('message', message);
    if (image) formData.append('image', image);
    formData.append('conversation_id', 'session_current');

    /* 
      // Future Axios implementation with Laravel backend:
      const response = await axios.post('/api/chat', formData, {
          headers: { 'Content-Type': 'multipart/form-data' }
      });
      return response.data.reply;
    */

    // Mock response for development
    return new Promise((resolve) => {
        setTimeout(() => {
            if (image) {
                resolve("I've analyzed your image using our vision-capable AI agent. This matches our catalog items with high precision!");
            } else if (message.toLowerCase().includes('laptop')) {
                resolve("Our top recommendation is the HP Pavilion 15 at $650, featuring an Intel Core i5, 16GB RAM, and 512GB SSD.");
            } else {
                resolve(`I found relevant information regarding "${message}". Let me know if you want to add this to your cart!`);
            }
        }, 1000);
    });
};

defineExpose({
    sendMessage
});
</script>

<template>
    <div
        :class="['lg:col-span-3 fixed inset-y-0 right-0 z-50 w-full sm:w-96 lg:w-full lg:static lg:z-auto bg-white lg:rounded-2xl border border-slate-200 shadow-2xl lg:shadow-md flex flex-col h-[100vh] lg:h-[calc(100vh-7rem)] lg:sticky lg:top-24 transform transition-transform duration-300', isOpen ? 'translate-x-0' : 'translate-x-full lg:translate-x-0']">

        <!-- Chat Header -->
        <div class="bg-blue-600 text-white p-4 lg:rounded-t-2xl flex items-center justify-between shrink-0 shadow-sm">
            <div class="flex items-center gap-3">
                <div
                    class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center text-white border border-white/20">
                    <Bot class="w-5 h-5" />
                </div>
                <div>
                    <h3 class="font-bold text-sm tracking-tight">AI Shopping Assistant</h3>
                    <div class="flex items-center gap-1.5 text-[11px] text-blue-100">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>Online • Ready to help</span>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-1">
                <button @click="$emit('toggle-chat')"
                    class="lg:hidden p-1.5 text-blue-100 hover:text-white rounded-lg transition-colors">
                    <X class="w-5 h-5" />
                </button>
                <button class="hidden lg:block p-1.5 text-blue-100 hover:text-white rounded-lg transition-colors"
                    title="Minimize">
                    <Minus class="w-4 h-4" />
                </button>
            </div>
        </div>

        <!-- Chat Message Area -->
        <div ref="chatMessagesContainer" class="flex-1 p-4 overflow-y-auto space-y-4 text-sm bg-slate-50/50">
            <template v-for="(msg, index) in messages" :key="index">
                <!-- User Message -->
                <div v-if="msg.sender === 'user'" class="flex items-start justify-end gap-2.5">
                    <div class="bg-blue-600 text-white rounded-2xl rounded-tr-sm p-3.5 shadow-sm space-y-2 max-w-[85%]">
                        <img v-if="msg.image" :src="msg.image" alt="Uploaded"
                            class="w-48 h-36 object-cover rounded-xl border border-blue-500">
                        <p v-if="msg.text" class="text-xs sm:text-sm leading-relaxed whitespace-pre-wrap">{{ msg.text }}
                        </p>
                    </div>
                    <div
                        class="w-7 h-7 rounded-full bg-slate-200 text-slate-700 flex items-center justify-center shrink-0 mt-0.5">
                        <User class="w-4 h-4" />
                    </div>
                </div>

                <!-- AI Message -->
                <div v-else class="flex items-start gap-2.5">
                    <div
                        class="w-7 h-7 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0 mt-0.5">
                        <Bot class="w-4 h-4" />
                    </div>
                    <div
                        class="bg-white border border-slate-200/80 rounded-2xl rounded-tl-sm p-3.5 text-slate-800 shadow-sm space-y-1 max-w-[85%]">
                        <p class="font-medium text-xs text-blue-600">AI Assistant</p>
                        <p class="text-xs sm:text-sm leading-relaxed whitespace-pre-wrap">{{ msg.text }}</p>
                    </div>
                </div>
            </template>

            <!-- Typing Indicator -->
            <div v-if="isTyping" class="flex items-start gap-2.5">
                <div
                    class="w-7 h-7 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0 mt-0.5">
                    <Bot class="w-4 h-4" />
                </div>
                <div
                    class="bg-white border border-slate-200/80 rounded-2xl rounded-tl-sm p-3 text-slate-500 shadow-sm flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-blue-600 animate-bounce"></span>
                    <span class="w-2 h-2 rounded-full bg-blue-600 animate-bounce [animation-delay:0.2s]"></span>
                    <span class="w-2 h-2 rounded-full bg-blue-600 animate-bounce [animation-delay:0.4s]"></span>
                </div>
            </div>
        </div>

        <!-- Suggested Questions Bar -->
        <div class="p-3 bg-white border-t border-slate-100 shrink-0">
            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-2 px-1">Suggested Questions
            </p>
            <div class="flex flex-wrap gap-1.5">
                <button @click="sendMessage('Find a laptop under $700.')"
                    class="text-xs bg-slate-100 hover:bg-blue-50 hover:text-blue-600 text-slate-700 px-3 py-1.5 rounded-full border border-slate-200/60 transition-all text-left">
                    💻 Find a laptop under $700
                </button>
                <button @click="sendMessage('Compare smartphones.')"
                    class="text-xs bg-slate-100 hover:bg-blue-50 hover:text-blue-600 text-slate-700 px-3 py-1.5 rounded-full border border-slate-200/60 transition-all text-left">
                    📱 Compare smartphones
                </button>
                <button @click="sendMessage('Best headphones for gaming.')"
                    class="text-xs bg-slate-100 hover:bg-blue-50 hover:text-blue-600 text-slate-700 px-3 py-1.5 rounded-full border border-slate-200/60 transition-all text-left">
                    🎧 Best headphones for gaming
                </button>
            </div>
        </div>

        <!-- Image Preview -->
        <div v-if="selectedImageBase64"
            class="px-4 py-2 bg-white border-t border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <img :src="selectedImageBase64" alt="Preview"
                    class="w-12 h-12 rounded-lg object-cover border border-slate-200">
                <div>
                    <p class="text-xs font-semibold text-slate-700 truncate max-w-[180px]">{{ selectedImageFile?.name }}
                    </p>
                    <p class="text-[10px] text-slate-400">Ready to attach</p>
                </div>
            </div>
            <button @click="removeImage" class="p-1 text-slate-400 hover:text-red-500 rounded-full transition-colors">
                <X class="w-4 h-4" />
            </button>
        </div>

        <!-- Chat Input Area -->
        <div class="p-3 bg-white border-t border-slate-200 rounded-b-2xl shrink-0">
            <form @submit.prevent="sendMessage(null)" class="space-y-2">
                <div class="relative flex items-center">
                    <textarea v-model="userInput" @keydown.enter.exact.prevent="sendMessage(null)" rows="1"
                        placeholder="Ask anything about products..."
                        class="w-full pl-3 pr-20 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:bg-white resize-none max-h-24"></textarea>

                    <div class="absolute right-2.5 flex items-center gap-1">
                        <label for="imageUploadInput"
                            class="p-1.5 text-slate-400 hover:text-blue-600 cursor-pointer rounded-lg transition-colors"
                            title="Upload image">
                            <Paperclip class="w-4 h-4" />
                        </label>
                        <input id="imageUploadInput" type="file" accept="image/jpeg,image/png,image/webp,image/jpg"
                            class="hidden" @change="previewImage">

                        <button type="submit"
                            class="p-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors flex items-center justify-center shadow-sm">
                            <Send class="w-4 h-4" />
                        </button>
                    </div>
                </div>
                <div class="flex items-center justify-between px-1">
                    <span class="text-[10px] text-slate-400 flex items-center gap-1">
                        <Info class="w-3 h-3" />
                        <span>AI can make mistakes. Please verify information.</span>
                    </span>
                    <span class="text-[10px] text-slate-400 hidden sm:inline">Press Enter ↵</span>
                </div>
            </form>
        </div>

    </div>
</template>