<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {
  Head,
  Link,
  router,
  useForm,
} from '@inertiajs/vue3';

const props = defineProps({
    skill: Object
});
const form = useForm({
    name: props.skill?.name,
    image: null
});
function onFileChanged(e) {
    const files = e.target.files;
    form.image = files[0];
}
function updateSkill() {
    console.log(props.skill);
    router.post(`/skills/${props.skill.id}`, {
        '_method': 'put',
        'name': form.name,
        'image':form.image 
      })
 }
</script>
<template>
    <Head title="Skills create" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
               Update Skills
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form @submit.prevent="updateSkill">
                    <div>
                        <InputLabel for="name" value="name" />
                        <TextInput
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.name"
                            required
                            autofocus
                            autocomplete="name"
                        />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>
                    <div>
                        <InputLabel for="image" value="image" />
                        <TextInput
                            type="file"
                            class="mt-1 block w-full"
                            @change="onFileChanged"
                        />
                        <InputError class="mt-2" :message="form.errors.image" />
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <PrimaryButton
                            class="ml-4"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            yes !  update
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
