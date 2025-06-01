
<template>
  <div class="max-w-4xl mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md p-8">
      <h1 class="text-3xl font-bold text-gray-900 mb-8">AI Quote Generator</h1>
      
      <form @submit.prevent="generateQuote" class="space-y-6">
        <div>
          <label for="client_message" class="block text-sm font-medium text-gray-700 mb-2">
            Customer Message
          </label>
          <textarea
            id="client_message"
            v-model="form.client_message"
            rows="4"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Enter the customer's inquiry here..."
            required
          ></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
              Location (Optional)
            </label>
            <input
              id="location"
              v-model="form.location"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="e.g., Bondi, NSW"
            />
          </div>

          <div>
            <label for="response_tone" class="block text-sm font-medium text-gray-700 mb-2">
              Response Tone
            </label>
            <select
              id="response_tone"
              v-model="form.response_tone"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              <option value="casual">Casual</option>
              <option value="polite">Polite</option>
              <option value="professional">Professional</option>
            </select>
          </div>
        </div>

        <div>
          <label for="preferred_cta" class="block text-sm font-medium text-gray-700 mb-2">
            Preferred Call-to-Action (Optional)
          </label>
          <input
            id="preferred_cta"
            v-model="form.preferred_cta"
            type="text"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="e.g., Call me on 0412 345 678 to book"
          />
        </div>

        <button
          type="submit"
          :disabled="isGenerating"
          class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed"
        >
          <span v-if="isGenerating" class="flex items-center justify-center">
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Generating...
          </span>
          <span v-else>Generate Quote</span>
        </button>
      </form>

      <!-- Generated Quote Display -->
      <div v-if="generatedQuote" class="mt-8 p-6 bg-gray-50 rounded-lg">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-semibold text-gray-900">Generated Quote</h3>
          <span class="text-sm text-gray-500">{{ characterCount }} characters</span>
        </div>
        
        <div class="bg-white p-4 rounded border">
          <p class="whitespace-pre-wrap">{{ generatedQuote }}</p>
        </div>

        <div class="mt-4 flex space-x-3">
          <button
            @click="copyToClipboard"
            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
          >
            Copy to Clipboard
          </button>
          
          <button
            @click="showImproveModal = true"
            class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700"
          >
            Improve Response
          </button>

          <button
            @click="sendViaSms"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
          >
            Send via SMS
          </button>
        </div>
      </div>

      <!-- Job Analysis -->
      <div v-if="jobAnalysis" class="mt-8 p-6 bg-blue-50 rounded-lg">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Job Analysis</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <p><strong>Complexity:</strong> {{ jobAnalysis.complexity_level }}</p>
            <p><strong>Estimated Hours:</strong> {{ jobAnalysis.estimated_hours }}</p>
          </div>
          <div>
            <p><strong>Required Skills:</strong></p>
            <ul class="list-disc list-inside">
              <li v-for="skill in jobAnalysis.required_skills" :key="skill">{{ skill }}</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Improve Quote Modal -->
    <div v-if="showImproveModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
        <h3 class="text-lg font-semibold mb-4">Improve Quote Response</h3>
        
        <textarea
          v-model="improvements"
          rows="4"
          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4"
          placeholder="Describe what improvements you'd like to make..."
        ></textarea>

        <div class="flex space-x-3">
          <button
            @click="improveQuote"
            :disabled="isImproving"
            class="flex-1 bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 disabled:opacity-50"
          >
            {{ isImproving ? 'Improving...' : 'Improve' }}
          </button>
          
          <button
            @click="showImproveModal = false"
            class="flex-1 bg-gray-600 text-white py-2 px-4 rounded hover:bg-gray-700"
          >
            Cancel
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'

const form = ref({
  client_message: '',
  location: '',
  response_tone: 'polite',
  preferred_cta: ''
})

const generatedQuote = ref('')
const jobAnalysis = ref(null)
const isGenerating = ref(false)
const isImproving = ref(false)
const showImproveModal = ref(false)
const improvements = ref('')

const characterCount = computed(() => generatedQuote.value.length)

const generateQuote = async () => {
  isGenerating.value = true
  
  try {
    const response = await fetch('/ai/generate-quote', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify(form.value)
    })

    const data = await response.json()
    
    if (data.success) {
      generatedQuote.value = data.response
      
      // Also analyze the job
      analyzeJob()
    }
  } catch (error) {
    console.error('Error generating quote:', error)
  } finally {
    isGenerating.value = false
  }
}

const analyzeJob = async () => {
  try {
    const response = await fetch('/ai/analyze-job', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({
        client_message: form.value.client_message,
        job_type: 'general trades'
      })
    })

    const data = await response.json()
    
    if (data.success) {
      jobAnalysis.value = data.analysis
    }
  } catch (error) {
    console.error('Error analyzing job:', error)
  }
}

const improveQuote = async () => {
  isImproving.value = true
  
  try {
    const response = await fetch('/ai/improve-quote', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({
        original_response: generatedQuote.value,
        improvements: improvements.value
      })
    })

    const data = await response.json()
    
    if (data.success) {
      generatedQuote.value = data.improved_response
      showImproveModal.value = false
      improvements.value = ''
    }
  } catch (error) {
    console.error('Error improving quote:', error)
  } finally {
    isImproving.value = false
  }
}

const copyToClipboard = async () => {
  try {
    await navigator.clipboard.writeText(generatedQuote.value)
    alert('Quote copied to clipboard!')
  } catch (error) {
    console.error('Error copying to clipboard:', error)
  }
}

const sendViaSms = () => {
  // Integration with SMS functionality
  router.post('/twilio/send-message', {
    message: generatedQuote.value
  })
}
</script>
