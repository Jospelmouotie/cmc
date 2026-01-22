<template>
  <transition-group name="flash" tag="div" class="flash-container">
    <div
      v-for="flash in flashes"
      :key="flash.id"
      :class="['alert', `alert-${flash.type}`, 'alert-dismissible', 'fade', 'show']"
      role="alert"
    >
      <strong>{{ flash.message }}</strong>
      <button
        type="button"
        class="btn-close"
        @click="removeFlash(flash.id)"
        aria-label="Close"
      ></button>
    </div>
  </transition-group>
</template>

<script setup>
import { ref } from 'vue'

const flashes = ref([])
let flashId = 0

const showFlash = (message, type = 'info', duration = 5000) => {
  const id = flashId++
  flashes.value.push({ id, message, type })
  
  if (duration > 0) {
    setTimeout(() => {
      removeFlash(id)
    }, duration)
  }
}

const removeFlash = (id) => {
  const index = flashes.value.findIndex(f => f.id === id)
  if (index > -1) {
    flashes.value.splice(index, 1)
  }
}

// Expose methods to parent
defineExpose({
  showFlash,
  success: (message, duration) => showFlash(message, 'success', duration),
  error: (message, duration) => showFlash(message, 'danger', duration),
  warning: (message, duration) => showFlash(message, 'warning', duration),
  info: (message, duration) => showFlash(message, 'info', duration)
})
</script>

<style scoped>
.flash-container {
  position: fixed;
  top: 20px;
  right: 20px;
  z-index: 9999;
  max-width: 400px;
}

.alert {
  margin-bottom: 10px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Transition animations */
.flash-enter-active {
  animation: slideInRight 0.3s ease-out;
}

.flash-leave-active {
  animation: slideOutRight 0.3s ease-in;
}

@keyframes slideInRight {
  from {
    transform: translateX(100%);
    opacity: 0;
  }
  to {
    transform: translateX(0);
    opacity: 1;
  }
}

@keyframes slideOutRight {
  from {
    transform: translateX(0);
    opacity: 1;
  }
  to {
    transform: translateX(100%);
    opacity: 0;
  }
}
</style>
