<script setup>
import { ref, computed } from 'vue'
import { useForm, usePage, router,Link } from '@inertiajs/vue3'

const props = defineProps({
  menuItems: Array,
})

const page = usePage()
const successMessage = computed(() => page.props.flash?.success)
// updated later
const user = computed(() => page.props.auth?.user)

const logout = () => {
  router.post('/logout')
}
//end of updation
const showModal = ref(false)
const editingItem = ref(null)

const categories = ['Appetizer', 'Main Course', 'Dessert', 'Beverage', 'Side Dish']

const form = useForm({
  name: '',
  description: '',
  price: '',
  category: 'Main Course',
  is_available: true,
  image: null,
})

const imagePreview = ref(null)

const handleImageChange = (event) => {
  const file = event.target.files[0]
  form.image = file
  if (file) {
    imagePreview.value = URL.createObjectURL(file)
  }
}

const openAddModal = () => {
  editingItem.value = null
  form.reset()
  form.clearErrors()
  showModal.value = true
}

const openEditModal = (item) => {
  editingItem.value = item
  form.name = item.name
  form.description = item.description || ''
  form.price = item.price
  form.category = item.category
  form.is_available = item.is_available
  form.image = null
  form.clearErrors()
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
  editingItem.value = null
  imagePreview.value = null
  form.reset()
}

const submit = () => {
  if (editingItem.value) {
    form.post(`/dashboard/menu-items/${editingItem.value.id}`, {
      forceFormData: true,
      onSuccess: () => closeModal(),
      onBefore: () => form.transform((data) => ({ ...data, _method: 'put' })),
    })
  } else {
    form.post('/dashboard/menu-items', {
      forceFormData: true,
      onSuccess: () => closeModal(),
    })
  }
}

const deleteItem = (item) => {
  if (confirm(`Delete "${item.name}"? This cannot be undone.`)) {
    router.delete(`/dashboard/menu-items/${item.id}`)
  }
}

const formatPrice = (price) => `$${parseFloat(price).toFixed(2)}`
</script>

<template>
  <div class="min-h-screen bg-gray-50">

    <!-- Header -->
 <header class="bg-white border-b border-gray-200 sticky top-0 z-40">
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-5 flex items-center justify-between">
    <div>
      <h1 class="text-xl font-bold text-gray-900">Restaurant Dashboard</h1>
      <p class="text-sm text-gray-500">
        Manage your menu items <span v-if="user">— logged in as {{ user.name }}</span>
      </p>
    </div>
    <div class="flex items-center gap-3">
      <Link
        href="/"
        class="px-4 py-2.5 rounded-lg border border-gray-300 text-gray-600 font-medium hover:bg-gray-50 transition-colors duration-200"
      >
        View Storefront
      </Link>
      <button
        @click="openAddModal"
        class="px-5 py-2.5 rounded-lg bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200"
      >
        + Add Menu Item
      </button>
      <button
        @click="logout"
        class="px-4 py-2.5 rounded-lg border border-gray-300 text-gray-600 font-medium hover:bg-gray-50 transition-colors duration-200"
      >
        Log out
      </button>
    </div>
  </div>
</header>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

      <!-- Success banner -->
      <div
        v-if="successMessage"
        class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm font-medium"
      >
        {{ successMessage }}
      </div>

      <!-- Empty state -->
      <div v-if="menuItems.length === 0" class="text-center py-20 bg-white rounded-2xl border border-dashed border-gray-300">
        <div class="text-5xl mb-4">🍽️</div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">No menu items yet</h3>
        <p class="text-gray-500 mb-6">Start building your menu by adding your first dish.</p>
        <button
          @click="openAddModal"
          class="px-6 py-2.5 rounded-lg bg-orange-600 text-white font-semibold hover:bg-orange-700 transition-colors"
        >
          Add Your First Item
        </button>
      </div>

      <!-- Menu items grid -->
      <div v-else class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="item in menuItems"
          :key="item.id"
          class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition-shadow duration-300 overflow-hidden"
        >
          <div class="p-6">
            <div class="flex items-start justify-between mb-3">
              <div>
                <span class="inline-block px-2.5 py-0.5 rounded-full bg-orange-50 text-orange-600 text-xs font-semibold mb-2">
                  {{ item.category }}
                </span>
                <h3 class="text-lg font-bold text-gray-900">{{ item.name }}</h3>
              </div>
              <span
                class="px-2 py-0.5 rounded-full text-xs font-semibold whitespace-nowrap"
                :class="item.is_available ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500'"
              >
                {{ item.is_available ? 'Available' : 'Unavailable' }}
              </span>
            </div>

            <p class="text-sm text-gray-500 mb-4 line-clamp-2 min-h-[2.5rem]">
              {{ item.description || 'No description provided.' }}
            </p>

            <div class="flex items-center justify-between">
              <span class="text-xl font-extrabold text-gray-900">{{ formatPrice(item.price) }}</span>
              <div class="flex gap-2">
                <button
                  @click="openEditModal(item)"
                  class="px-3 py-1.5 text-sm rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50 transition-colors"
                >
                  Edit
                </button>
                <button
                  @click="deleteItem(item)"
                  class="px-3 py-1.5 text-sm rounded-lg border border-red-200 text-red-600 hover:bg-red-50 transition-colors"
                >
                  Delete
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Add/Edit Modal -->
    <transition
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition duration-150 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div v-if="showModal" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4" @click.self="closeModal">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6">
          <h2 class="text-xl font-bold text-gray-900 mb-5">
            {{ editingItem ? 'Edit Menu Item' : 'Add Menu Item' }}
          </h2>

          <form @submit.prevent="submit" class="space-y-4">
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1.5">Dish Name</label>
              <input
                v-model="form.name"
                type="text"
                placeholder="Margherita Pizza"
                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-100 outline-none transition"
              />
              <p v-if="form.errors.name" class="text-sm text-red-600 mt-1">{{ form.errors.name }}</p>
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1.5">Description</label>
              <textarea
                v-model="form.description"
                rows="2"
                placeholder="Fresh tomatoes, mozzarella, basil..."
                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-100 outline-none transition resize-none"
              ></textarea>
              <p v-if="form.errors.description" class="text-sm text-red-600 mt-1">{{ form.errors.description }}</p>
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Price ($)</label>
                <input
                  v-model="form.price"
                  type="number"
                  step="0.01"
                  placeholder="12.99"
                  class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-100 outline-none transition"
                />
                <p v-if="form.errors.price" class="text-sm text-red-600 mt-1">{{ form.errors.price }}</p>
              </div>

              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Category</label>
                <select
                  v-model="form.category"
                  class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-100 outline-none transition"
                >
                  <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
                </select>
              </div>
            </div>
            <div>
  <label class="block text-sm font-semibold text-gray-700 mb-1.5">Dish Photo</label>
  <input
    type="file"
    accept="image/*"
    @change="handleImageChange"
    class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-orange-50 file:text-orange-700 file:font-semibold hover:file:bg-orange-100"
  />
  <div v-if="imagePreview" class="mt-2">
    <img :src="imagePreview" class="w-24 h-24 object-cover rounded-lg border border-gray-200" />
  </div>
  <div v-else-if="editingItem?.image_path" class="mt-2">
    <img :src="`/storage/${editingItem.image_path}`" class="w-24 h-24 object-cover rounded-lg border border-gray-200" />
  </div>
  <p v-if="form.errors.image" class="text-sm text-red-600 mt-1">{{ form.errors.image }}</p>
</div>

            <label v-if="editingItem" class="flex items-center gap-2 cursor-pointer">
              <input v-model="form.is_available" type="checkbox" class="w-4 h-4 rounded border-gray-300 text-orange-600 focus:ring-orange-500" />
              <span class="text-sm font-medium text-gray-700">Available on menu</span>
            </label>

            <div class="flex gap-3 pt-2">
              <button
                type="button"
                @click="closeModal"
                class="flex-1 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 transition-colors"
              >
                Cancel
              </button>
              <button
                type="submit"
                :disabled="form.processing"
                class="flex-1 py-2.5 rounded-lg bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold shadow-md hover:shadow-lg transition-all disabled:opacity-50"
              >
                {{ form.processing ? 'Saving...' : (editingItem ? 'Save Changes' : 'Add Item') }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </transition>
  </div>
</template>
