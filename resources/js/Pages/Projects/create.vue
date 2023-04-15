<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {
  Head,
  Link,
  useForm,
} from '@inertiajs/vue3';

defineProps({
    skills: Array
});

const form = useForm({
    name: "",
   project_link: '',
    image: null,
    skill_id: ''
});
function onFileChanged(e) {
  const files = e.target.files;
  form.image = files[0];
}
function storeProject() {
   form.post(route("projects.store"));
}
</script>
<template>
  <Head title="project create" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Add New Projects
      </h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <form @submit.prevent="storeProject">
          <div>
            <InputLabel for="name" value="name" />
            <TextInput
              type="text"
              class="mt-1 block w-full"
              v-model="form.name"

              autofocus
              autocomplete="name"
            />
            <InputError class="mt-2" :message="form.errors.name" />
          </div>


             <div>
            <InputLabel for="project_link" value="project_link" />
            <TextInput
              type="text"
              class="mt-1 block w-full"
              v-model="form.project_link"

              autofocus
              autocomplete="project_link"
            />
            <InputError class="mt-2" :message="form.errors.project_link" />
          </div>

             <div>
            <InputLabel for="skills" value="skills" />
            <select v-model="form.skill_id"   class="mt-1 block w-full">
                <option v-for="skill in skills" :key="skill.id" :value="skill.id">{{ skill.name  }}</option>
            </select>
            <InputError class="mt-2" :message="form.errors.skill_id" />
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
              yes ! create one
            </PrimaryButton>
          </div>
        </form>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
