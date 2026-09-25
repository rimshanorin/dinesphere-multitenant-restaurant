<script setup>
import { ref, computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'

const props = defineProps({
  restaurantName: String,
  menuItems: {
    type: Array,
    default: () => [],
  },
})

const page = usePage()
const user = computed(() => page.props.auth?.user)

const activeCategory = ref('All')

const categories = computed(() => {
  const cats = [...new Set(props.menuItems.map((item) => item.category))]
  return ['All', ...cats]
})

const availableItems = computed(() =>
  props.menuItems.filter((item) => item.is_available)
)

const filteredItems = computed(() => {
  if (activeCategory.value === 'All') return availableItems.value
  return availableItems.value.filter((item) => item.category === activeCategory.value)
})

const formatPrice = (price) => `$${parseFloat(price).toFixed(2)}`

const categoryEmoji = {
  Appetizer: '🥗',
  'Main Course': '🍽️',
  Dessert: '🍰',
  Beverage: '🥤',
  'Side Dish': '🍟',
}
</script>

<template>
  <div class="min-h-screen bg-gray-50">

    <!-- Hero -->
    <section class="bg-gradient-to-r from-orange-500 to-red-500 py-16 sm:py-20">
      <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="text-5xl mb-4">🍴</div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white">{{ restaurantName }}</h1>
        <p class="mt-3 text-orange-50 text-lg">Explore our menu and find your next favorite dish</p>
      </div>
    </section>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

      <!-- Category filter -->
      <div class="flex flex-wrap gap-2 mb-10 justify-center">
        <button
          v-for="cat in categories"
          :key="cat"
          @click="activeCategory = cat"
          class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-200"
          :class="activeCategory === cat
            ? 'bg-orange-600 text-white shadow-md'
            : 'bg-white text-gray-600 border border-gray-200 hover:border-orange-300 hover:text-orange-600'"
        >
          {{ cat }}
        </button>
      </div>

      <!-- Empty state -->
      <div v-if="filteredItems.length === 0" class="text-center py-20">
        <div class="text-5xl mb-4">🍽️</div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">No dishes available right now</h3>
        <p class="text-gray-500">Please check back soon — we're updating our menu.</p>
      </div>

      <!-- Menu grid -->
      <div v-else class="grid sm:grid-cols-2 gap-6">
        <div
          v-for="item in filteredItems"
          :key="item.id"
          class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl transition-shadow duration-300 overflow-hidden flex"
        >
          <div class="w-24 sm:w-28 bg-gradient-to-br from-orange-100 to-yellow-100 flex items-center justify-center text-4xl flex-shrink-0">
            {{ categoryEmoji[item.category] || '🍽️' }}
          </div>
          <div class="p-5 flex-1">
            <div class="flex items-start justify-between gap-3 mb-1.5">
              <h3 class="font-bold text-gray-900">{{ item.name }}</h3>
              <span class="text-lg font-extrabold text-orange-600 whitespace-nowrap">
                {{ formatPrice(item.price) }}
              </span>
            </div>
            <p class="text-sm text-gray-500 leading-relaxed">
              {{ item.description || 'A delicious choice from our kitchen.' }}
            </p>
          </div>
        </div>
      </div>
    </div>

  <!-- Footer -->
<footer class="bg-gray-900 text-gray-400 py-8 text-center text-sm mt-10">
  <p>© {{ new Date().getFullYear() }} {{ restaurantName }} — Powered by DineSphere</p>
  <Link
    :href="user ? '/dashboard' : '/login'"
    class="inline-block mt-3 text-xs text-gray-500 hover:text-orange-400 transition-colors duration-200"
  >
    {{ user ? '→ Go to Dashboard' : 'Staff Login' }}
  </Link>
</footer>
  </div>
</template>
