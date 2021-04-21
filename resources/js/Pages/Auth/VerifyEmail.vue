<template>
    <jet-authentication-card>
        <template #logo>
            <jet-authentication-card-logo />
        </template>

        <div class="mb-4 text-sm text-gray-600">
               Grazie per esserti registrato! Ti è stata inviata una mail di verifica, clicca sul link presente per confermare la tua registrazione.
        </div>

        <div class="mb-4 font-medium text-sm text-green-600" v-if="verificationLinkSent" >
            Sulla tua mail è stato inviato un nuovo link di verifica, controlla e clicca sul link presente nella mail per confermare la registrazione.
        </div>

        <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
                <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Inviami una nuova mail di verifica
                </jet-button>

                <inertia-link :href="route('logout')" method="post" as="button" class="underline text-sm text-gray-600 hover:text-gray-900">Log Out</inertia-link>
            </div>
        </form>
    </jet-authentication-card>
</template>

<script>
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo'
    import JetButton from '@/Jetstream/Button'

    export default {
        components: {
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
        },

        props: {
            status: String
        },

        data() {
            return {
                form: this.$inertia.form()
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('verification.send'))
            },
        },

        computed: {
            verificationLinkSent() {
                return this.status === 'verification-link-sent';
            }
        }
    }
</script>
