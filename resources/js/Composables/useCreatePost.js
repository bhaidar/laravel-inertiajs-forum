import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const visible = ref(false);
const discussion = ref(null);
const form = useForm({
    body: '',
});

export default () => {
    const showCreatePostForm = (discussionContext) => {
        visible.value = true;
        discussion.value = discussionContext;
    };
    const hideCreatePostForm = () => (visible.value = false);
    return {
        discussion,
        form,
        hideCreatePostForm,
        showCreatePostForm,
        visible,
    };
};
