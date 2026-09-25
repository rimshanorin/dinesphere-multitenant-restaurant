<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
})

const submit = () => {
  form.post('/register', {
    onFinish: () => form.reset('password', 'password_confirmation'),
  })
}
</script>

<template>
  <Head title="Register" />

  <div class="min-h-screen flex items-center justify-center bg-gradient-to-b from-orange-50 via-white to-white px-4 py-10">
    <div class="w-full max-w-md">

      <div class="text-center mb-8">
        <Link href="/" class="inline-flex items-center gap-2">
          <span class="text-3xl">🍽️</span>
          <span class="text-2xl font-extrabold text-gray-900">
            Dine<span class="text-orange-600">Sphere</span>
          </span>
        </Link>
        <h1 class="mt-6 text-2xl font-bold text-gray-900">Create your account</h1>
        <p class="mt-1 text-gray-500 text-sm">Set up staff access for your restaurant</p>
      </div>

      <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
        <form @submit.prevent="submit" class="space-y-5">
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Name</label>
            <input
              v-model="form.name"
              type="text"
              autofocus
              autocomplete="name"
              class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-100 outline-none transition"
            />
            <p v-if="form.errors.name" class="text-sm text-red-600 mt-1">{{ form.errors.name }}</p>
          </div>

          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
            <input
              v-model="form.email"
              type="email"
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
              autocomplete="new-password"
              class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-100 outline-none transition"
            />
            <p v-if="form.errors.password" class="text-sm text-red-600 mt-1">{{ form.errors.password }}</p>
          </div>

          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Confirm Password</label>
            <input
              v-model="form.password_confirmation"
              type="password"
              autocomplete="new-password"
              class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-100 outline-none transition"
            />
            <p v-if="form.errors.password_confirmation" class="text-sm text-red-600 mt-1">{{ form.errors.password_confirmation }}</p>
          </div>

          <button
            type="submit"
            :disabled="form.processing"
            class="w-full py-3 rounded-lg bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 disabled:opacity-50"
          >
            {{ form.processing ? 'Creating account...' : 'Create Account' }}
          </button>
        </form>
      </div>

      <p class="text-center text-sm text-gray-500 mt-6">
        Already have an account?
        <Link href="/login" class="font-semibold text-orange-600 hover:text-orange-700">Log in</Link>
      </p>
    </div>
  </div>
</template>
