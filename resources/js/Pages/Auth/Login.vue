<script setup>
import { ref } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

defineProps({
  canResetPassword: Boolean,
  status: String,
})

const form = useForm({
  email: '',
  password: '',
  remember: false,
})

const submit = () => {
  form.post('/login', {
    onFinish: () => form.reset('password'),
  })
}
</script>

<template>
  <Head title="Log in" />

  <div class="min-h-screen flex items-center justify-center bg-gradient-to-b from-orange-50 via-white to-white px-4">
    <div class="w-full max-w-md">

      <div class="text-center mb-8">
        <Link href="/" class="inline-flex items-center gap-2">
          <span class="text-3xl">🍽️</span>
          <span class="text-2xl font-extrabold text-gray-900">
            Dine<span class="text-orange-600">Sphere</span>
          </span>
        </Link>
        <h1 class="mt-6 text-2xl font-bold text-gray-900">Welcome back</h1>
        <p class="mt-1 text-gray-500 text-sm">Log in to manage your restaurant</p>
      </div>

      <div
        v-if="status"
        class="mb-4 text-sm font-medium text-green-600 bg-green-50 border border-green-200 rounded-lg px-4 py-3"
      >
        {{ status }}
      </div>

      <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
        <form @submit.prevent="submit" class="space-y-5">
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
            <input
              v-model="form.email"
              type="email"
              autofocus
              autocomplete="username"
              class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-100 outline-none transition"
            />
            <p v-if="form.errors.email" class="text-sm text-red-600 mt-1">{{ form.errors.email }}</p>
          </div>

          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
            <input
              v-model="form.password"
              type="password"
              autocomplete="current-password"
              class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-100 outline-none transition"
            />
            <p v-if="form.errors.password" class="text-sm text-red-600 mt-1">{{ form.errors.password }}</p>
          </div>

          <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 cursor-pointer">
              <input v-model="form.remember" type="checkbox" class="w-4 h-4 rounded border-gray-300 text-orange-600 focus:ring-orange-500" />
              <span class="text-sm text-gray-600">Remember me</span>
            </label>
            <Link
              v-if="canResetPassword"
              href="/forgot-password"
              class="text-sm font-medium text-orange-600 hover:text-orange-700"
            >
              Forgot password?
            </Link>
          </div>

          <button
            type="submit"
            :disabled="form.processing"
            class="w-full py-3 rounded-lg bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 disabled:opacity-50"
          >
            {{ form.processing ? 'Logging in...' : 'Log in' }}
          </button>
        </form>
      </div>

      <!-- <p class="text-center text-sm text-gray-500 mt-6">
        Don't have an account?
        <Link href="/register" class="font-semibold text-orange-600 hover:text-orange-700">Sign up</Link>
      </p> -->
    </div>
  </div>
</template>
