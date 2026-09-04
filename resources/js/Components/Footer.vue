<script setup>
const year = new Date().getFullYear()

const footerLinks = {
  Company: ['About', 'Careers', 'Contact'],
  Support: ['Help Center', 'Terms of Service', 'Privacy Policy'],
  'For Restaurants': ['Join DineSphere', 'Pricing', 'Restaurant Login'],
}
</script>

<template>
  <footer class="bg-gray-900 text-gray-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
      <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-10">

        <div>
          <div class="flex items-center gap-2 mb-4">
            <span class="text-2xl">🍽️</span>
            <span class="text-xl font-extrabold text-white">
              Dine<span class="text-orange-500">Sphere</span>
            </span>
          </div>
          <p class="text-sm text-gray-400 leading-relaxed">
            The multi-tenant platform empowering restaurants to launch beautiful ordering websites in minutes.
          </p>
        </div>

        <div v-for="(links, category) in footerLinks" :key="category">
          <h4 class="text-white font-semibold mb-4">{{ category }}</h4>
          <ul class="space-y-2">
            <li v-for="link in links" :key="link">
              <a href="#" class="text-sm text-gray-400 hover:text-orange-400 transition-colors duration-200">
                {{ link }}
              </a>
            </li>
          </ul>
        </div>
      </div>

      <div class="border-t border-gray-800 mt-12 pt-8 text-center">
        <p class="text-sm text-gray-500">© {{ year }} DineSphere. All rights reserved.</p>
      </div>
    </div>
  </footer>
</template>
