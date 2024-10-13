import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const visible = ref(true);
const form = useForm({
    topic_id: '',
    title: '',
    body: '',
});

export default () => {
    const showCreateDiscussionForm = () => (visible.value = true);
    const hideCreateDiscussionForm = () => (visible.value = false);
    return {
        form,
        hideCreateDiscussionForm,
        showCreateDiscussionForm,
        visible,
    };
};
