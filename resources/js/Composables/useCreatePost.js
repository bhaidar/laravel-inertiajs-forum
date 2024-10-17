import { useForm } from '@inertiajs/vue3';
import { onMounted, onUnmounted, ref } from 'vue';

const visible = ref(false);
const discussion = ref(null);
const user = ref(null);
const form = useForm({
    body: '',
});

export default () => {
    const showCreatePostForm = (discussionContext, userContext = null) => {
        visible.value = true;
        discussion.value = discussionContext;
        user.value = userContext;
    };
    const hideCreatePostForm = () => (visible.value = false);

    const handleEscKey = (event) => {
        if (event.key === 'Escape') {
            hideCreatePostForm();
        }
    };

    onMounted(() => {
        document.addEventListener('keydown', handleEscKey);
    });

    onUnmounted(() => {
        document.removeEventListener('keydown', handleEscKey);
    });

    return {
        discussion,
        form,
        hideCreatePostForm,
        showCreatePostForm,
        visible,
        user,
    };
};
