<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'

const features = [
  { icon: '🏪', title: 'Multi-Restaurant Platform', desc: 'Each restaurant gets its own branded storefront with a custom domain or subdomain.' },
  { icon: '⚡', title: 'Lightning Fast', desc: 'Built with Laravel 11 and Inertia.js for a smooth, single-page app experience.' },
  { icon: '🔒', title: 'Fully Isolated Data', desc: 'Every tenant\'s orders, menus, and customers are securely separated at the database level.' },
  { icon: '📱', title: 'Responsive by Design', desc: 'Looks and works great on phones, tablets, and desktops — no compromises.' },
]

const restaurants = [
  { name: 'La Piazza', cuisine: 'Italian', image: '🍝', rating: 4.8 },
  { name: 'Spice Route', cuisine: 'Indian', image: '🍛', rating: 4.6 },
  { name: 'Sushi Zen', cuisine: 'Japanese', image: '🍣', rating: 4.9 },
]
</script>

<template>
  <AppLayout>
    <section class="relative pb-24 overflow-hidden bg-gradient-to-b from-orange-50 via-white to-white">
      <div class="absolute -top-24 -right-24 w-96 h-96 bg-orange-200 rounded-full mix-blend-multiply blur-3xl opacity-40"></div>
      <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-yellow-200 rounded-full mix-blend-multiply blur-3xl opacity-40"></div>

      <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center pt-16">
        <span class="inline-block px-4 py-1.5 rounded-full bg-orange-100 text-orange-700 text-sm font-semibold mb-6">
          🚀 Multi-Tenant Restaurant Platform
        </span>

        <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-gray-900 leading-tight tracking-tight">
          One Platform. <br class="hidden sm:block" />
          <span class="bg-gradient-to-r from-orange-500 to-red-500 bg-clip-text text-transparent">
            Every Restaurant.
          </span>
        </h1>

        <p class="mt-6 text-lg md:text-xl text-gray-600 max-w-2xl mx-auto">
          DineSphere lets restaurants launch their own branded ordering website in minutes —
          each with its own domain, menu, and dashboard, all powered by one platform.
        </p>

        <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
          <Link href="/register" class="w-full sm:w-auto px-8 py-3.5 rounded-full bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold shadow-lg hover:shadow-orange-300/50 hover:-translate-y-0.5 transition-all duration-200">
            Start Your Restaurant
          </Link>
          <Link href="/restaurants" class="w-full sm:w-auto px-8 py-3.5 rounded-full border-2 border-gray-200 text-gray-700 font-semibold hover:border-orange-300 hover:text-orange-600 transition-all duration-200">
            Browse Restaurants
          </Link>
        </div>
      </div>
    </section>

    <section class="py-20 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16">
          <h2 class="text-3xl sm:text-4xl font-bold text-gray-900">Why DineSphere?</h2>
          <p class="mt-4 text-gray-600">Everything a restaurant needs to go online, without the technical headache.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
          <div
            v-for="feature in features"
            :key="feature.title"
            class="p-6 rounded-2xl border border-gray-100 hover:border-orange-200 hover:shadow-xl hover:shadow-orange-100/50 transition-all duration-300 group"
          >
            <div class="text-4xl mb-4 transition-transform duration-300 group-hover:scale-110">{{ feature.icon }}</div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">{{ feature.title }}</h3>
            <p class="text-sm text-gray-600 leading-relaxed">{{ feature.desc }}</p>
          </div>
        </div>
      </div>
    </section>

    <section class="py-20 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between mb-12 gap-4">
          <div>
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900">Featured Restaurants</h2>
            <p class="mt-2 text-gray-600">Discover top-rated places already on DineSphere.</p>
          </div>
          <Link href="/restaurants" class="text-orange-600 font-semibold hover:text-orange-700 whitespace-nowrap">
            View all →
          </Link>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
          <div
            v-for="restaurant in restaurants"
            :key="restaurant.name"
            class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl transition-shadow duration-300 group cursor-pointer"
          >
            <div class="h-48 bg-gradient-to-br from-orange-100 to-yellow-100 flex items-center justify-center text-7xl group-hover:scale-105 transition-transform duration-300">
              {{ restaurant.image }}
            </div>
            <div class="p-6">
              <div class="flex items-center justify-between mb-2">
                <h3 class="text-xl font-bold text-gray-900">{{ restaurant.name }}</h3>
                <span class="flex items-center gap-1 text-sm font-semibold text-yellow-600">⭐ {{ restaurant.rating }}</span>
              </div>
              <p class="text-gray-500 text-sm">{{ restaurant.cuisine }} Cuisine</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="py-20 bg-gradient-to-r from-orange-500 to-red-500">
      <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">Ready to launch your restaurant online?</h2>
        <p class="text-orange-50 text-lg mb-8">Join DineSphere today and get your own branded ordering site — no coding required.</p>
        <Link href="/register" class="inline-block px-8 py-3.5 rounded-full bg-white text-orange-600 font-bold shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200">
          Get Started for Free
        </Link>
      </div>
    </section>
  </AppLayout>
</template>
