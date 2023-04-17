<template>
    <div class="container">
          <slot />
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue"
export default {
    components: {
        Link
    }
}
</script>

