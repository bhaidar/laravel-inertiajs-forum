import { useForm } from '@inertiajs/vue3';
import { onMounted, onUnmounted, ref } from 'vue';

const visible = ref(false);
const form = useForm({
    topic_id: '',
    title: '',
    body: '',
});

export default () => {
    const showCreateDiscussionForm = () => (visible.value = true);
    const hideCreateDiscussionForm = () => (visible.value = false);

    const handleEscKey = (event) => {
        if (event.key === 'Escape') {
            hideCreateDiscussionForm();
        }
    };

    onMounted(() => {
        document.addEventListener('keydown', handleEscKey);
    });

    onUnmounted(() => {
        document.removeEventListener('keydown', handleEscKey);
    });

    return {
        form,
        hideCreateDiscussionForm,
        showCreateDiscussionForm,
        visible,
    };
};
