<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'

defineProps({
  restaurants: Array,
})

const cuisineEmoji = {
  Italian: '🍝',
  Indian: '🍛',
  Japanese: '🍣',
  Chinese: '🥡',
  Mexican: '🌮',
  American: '🍔',
  'Fast Food': '🍟',
}
</script>

<template>
  <AppLayout>
    <section class="py-16 bg-gradient-to-b from-orange-50 via-white to-white min-h-screen">
      <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900">Discover Restaurants</h1>
          <p class="mt-3 text-gray-600">Browse restaurants currently live on DineSphere</p>
        </div>

        <div v-if="restaurants.length === 0" class="text-center py-20">
          <div class="text-5xl mb-4">🍽️</div>
          <h3 class="text-lg font-semibold text-gray-900 mb-2">No restaurants yet</h3>
          <p class="text-gray-500">Be the first to join DineSphere!</p>
        </div>

        <div v-else class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">

            <a
            v-for="restaurant in restaurants"
            :key="restaurant.name"
            :href="restaurant.url"
            class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl transition-shadow duration-300 group cursor-pointer block"
          >
            <div class="h-40 bg-gradient-to-br from-orange-100 to-yellow-100 flex items-center justify-center text-6xl group-hover:scale-105 transition-transform duration-300">
              {{ cuisineEmoji[restaurant.cuisine_type] || '🍽️' }}
            </div>
            <div class="p-6">
              <h3 class="text-xl font-bold text-gray-900 mb-1">{{ restaurant.name }}</h3>
              <p class="text-gray-500 text-sm">{{ restaurant.cuisine_type }} Cuisine</p>
            </div>
          </a>
        </div>
      </div>
    </section>
  </AppLayout>
</template>
