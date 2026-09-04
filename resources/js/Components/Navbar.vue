<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'

const mobileOpen = ref(false)
const scrolled = ref(false)

window.addEventListener('scroll', () => {
  scrolled.value = window.scrollY > 10
})

const navLinks = [
  { name: 'Home', href: '/' },
  { name: 'Restaurants', href: '/restaurants' },
  { name: 'Menu', href: '/menu' },
  { name: 'About', href: '/about' },
  { name: 'Contact', href: '/contact' },
]
</script>

<template>
  <nav
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
    :class="scrolled ? 'bg-white/90 backdrop-blur-md shadow-lg' : 'bg-white/60 backdrop-blur-sm'"
  >
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-20">

        <Link href="/" class="flex items-center gap-2 group">
          <span class="text-3xl transition-transform duration-300 group-hover:rotate-12">🍽️</span>
          <span class="text-2xl font-extrabold tracking-tight text-gray-900">
            Dine<span class="text-orange-600">Sphere</span>
          </span>
        </Link>

        <div class="hidden md:flex items-center gap-1">
          <Link
            v-for="link in navLinks"
            :key="link.name"
            :href="link.href"
            class="relative px-4 py-2 text-sm font-medium text-gray-700 hover:text-orange-600 transition-colors duration-200 group"
          >
            {{ link.name }}
            <span class="absolute left-4 right-4 bottom-1 h-0.5 bg-orange-600 scale-x-0 group-hover:scale-x-100 transition-transform duration-200 origin-left"></span>
          </Link>
        </div>

        <div class="hidden md:flex items-center gap-3">
          <Link href="/login" class="px-4 py-2 text-sm font-semibold text-gray-700 hover:text-orange-600 transition-colors duration-200">
            Log in
          </Link>
          <Link
            href="/register"
            class="px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-orange-500 to-orange-600 rounded-full shadow-md hover:shadow-orange-300/50 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200"
          >
            Get Started
          </Link>
        </div>

        <button
          @click="mobileOpen = !mobileOpen"
          class="md:hidden relative w-10 h-10 flex items-center justify-center text-gray-700 focus:outline-none"
        >
          <svg v-if="!mobileOpen" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
          <svg v-else class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>

    <transition
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="opacity-0 -translate-y-2"
      enter-to-class="opacity-100 translate-y-0"
      leave-active-class="transition duration-150 ease-in"
      leave-from-class="opacity-100 translate-y-0"
      leave-to-class="opacity-0 -translate-y-2"
    >
      <div v-if="mobileOpen" class="md:hidden bg-white border-t border-gray-100 px-4 pb-4 pt-2 space-y-1 shadow-lg">
        <Link
          v-for="link in navLinks"
          :key="link.name"
          :href="link.href"
          class="block px-3 py-2.5 rounded-lg text-gray-700 hover:bg-orange-50 hover:text-orange-600 font-medium transition-colors duration-200"
          @click="mobileOpen = false"
        >
          {{ link.name }}
        </Link>
        <hr class="my-2 border-gray-100" />
        <Link href="/login" class="block px-3 py-2.5 rounded-lg text-gray-700 hover:bg-orange-50 font-medium" @click="mobileOpen = false">
          Log in
        </Link>
        <Link
          href="/register"
          class="block text-center px-3 py-2.5 rounded-lg bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold"
          @click="mobileOpen = false"
        >
          Get Started
        </Link>
      </div>
    </transition>
  </nav>
</template>
