<script setup>
import FixedFormWrapper from '@/Components/Forum/FixedFormWrapper.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Select from '@/Components/Select.vue';
import Textarea from '@/Components/Textarea.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
</script>

<style lang="scss" scoped></style>
<template>
    <FixedFormWrapper>
        <template v-slot:header>
            <h1 class="text-lg font-medium">New discussion</h1>
        </template>

        <template v-slot:main>
            <div class="flex items-start space-x-3">
                <div class="flex-grow">
                    <div>
                        <InputLabel for="title" value="Title" class="sr-only" />

                        <TextInput id="title" type="text" class="w-full" />

                        <!--                        <InputError class="mt-2" :message="form.errors.email" />-->
                    </div>
                </div>
                <div>
                    <InputLabel for="topic" value="Topic" class="sr-only" />
                    <Select id="topic">
                        <option value="">Choose a topic</option>
                        <option
                            :value="topic.slug"
                            v-for="topic in $page.props.topics"
                            :key="topic.id"
                        >
                            {{ topic.name }}
                        </option>
                    </Select>
                </div>
            </div>

            <div class="mt-4">
                <Textarea class="w-full" rows="6" />
            </div>
        </template>

        <template v-slot:button>
            <PrimaryButton> Create discussion</PrimaryButton>
        </template>
    </FixedFormWrapper>
</template>
