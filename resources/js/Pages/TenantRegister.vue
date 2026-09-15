<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm } from '@inertiajs/vue3'

const form = useForm({
  restaurant_name: '',
  owner_name: '',
  owner_email: '',
  cuisine_type: '',
  subdomain: '',
})

const submit = () => {
  form.post('/register-restaurant')
}
</script>

<template>
  <AppLayout>
    <section class="py-16 bg-gradient-to-b from-orange-50 via-white to-white min-h-screen">
      <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-10">
          <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900">
            Launch Your Restaurant Online
          </h1>
          <p class="mt-3 text-gray-600">
            Get your own branded ordering site in seconds — no coding required.
          </p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
          <form @submit.prevent="submit" class="space-y-5">

            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1.5">Restaurant Name</label>
              <input
                v-model="form.restaurant_name"
                type="text"
                placeholder="La Piazza"
                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-100 outline-none transition"
              />
              <p v-if="form.errors.restaurant_name" class="text-sm text-red-600 mt-1">
                {{ form.errors.restaurant_name }}
              </p>
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1.5">Your Name</label>
              <input
                v-model="form.owner_name"
                type="text"
                placeholder="John Doe"
                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-100 outline-none transition"
              />
              <p v-if="form.errors.owner_name" class="text-sm text-red-600 mt-1">
                {{ form.errors.owner_name }}
              </p>
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
              <input
                v-model="form.owner_email"
                type="email"
                placeholder="you@example.com"
                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-100 outline-none transition"
              />
              <p v-if="form.errors.owner_email" class="text-sm text-red-600 mt-1">
                {{ form.errors.owner_email }}
              </p>
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1.5">Cuisine Type</label>
              <input
                v-model="form.cuisine_type"
                type="text"
                placeholder="Italian, Indian, Fast Food..."
                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-100 outline-none transition"
              />
              <p v-if="form.errors.cuisine_type" class="text-sm text-red-600 mt-1">
                {{ form.errors.cuisine_type }}
              </p>
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1.5">Choose Your Subdomain</label>
              <div class="flex items-center rounded-lg border border-gray-300 focus-within:border-orange-500 focus-within:ring-2 focus-within:ring-orange-100 transition overflow-hidden">
                <input
                  v-model="form.subdomain"
                  type="text"
                  placeholder="lapiazza"
                  class="flex-1 px-4 py-2.5 outline-none"
                />
                <span class="px-4 py-2.5 bg-gray-50 text-gray-500 text-sm border-l border-gray-300">
                  .localhost:8000
                </span>
              </div>
              <p v-if="form.errors.subdomain" class="text-sm text-red-600 mt-1">
                {{ form.errors.subdomain }}
              </p>
            </div>

            <button
              type="submit"
              :disabled="form.processing"
              class="w-full py-3.5 rounded-lg bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold shadow-lg hover:shadow-orange-300/50 hover:-translate-y-0.5 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-y-0"
            >
              {{ form.processing ? 'Creating your site...' : 'Create My Restaurant Site' }}
            </button>
          </form>
        </div>
      </div>
    </section>
  </AppLayout>
</template>
