<template>
    <jet-authentication-card>
        <!-- <template #logo>
            <jet-authentication-card-logo />
        </template> -->
        <h1 class="alert alert-info text-center"><strong>Registrazione utente</strong></h1>
        <jet-validation-errors class="mb-4" />

        <form @submit.prevent="submit">
            <div>
                <jet-label for="lastname" value="Cognome *" />
                <jet-input id="lastname" type="text" class="mt-1 block w-full" v-model="form.lastname" required autofocus autocomplete="lastname" />
            </div>
            <div class="mt-4">
                <jet-label for="name" value="Nome *" />
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autocomplete="name" />
            </div>

            <div class="mt-4">
                <jet-label for="birth" value="Data di nascita" />
                <jet-input id="birth" type="date" class="mt-1 block w-full" v-model="form.birth"  />
            </div>

            <div class="mt-4">
                <jet-label for="natoa" value="Luogo nascita" />
                <jet-input id="natoa" type="text" class="mt-1 block w-full" v-model="form.natoa" />
            </div>

            <div class="mt-4">
                <jet-label for="cfiscale" value="P.Iva/C. Fiscale" />
                <jet-input id="cfiscale" type="text" class="mt-1 block w-full" v-model="form.cfiscale" />
            </div>

            <div class="mt-4">
                <jet-label for="email" value="Email *" />
                <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required />
            </div>

            <div class="mt-4">
                <jet-label for="phone" value="Telefono" />
                <jet-input id="phone" type="text" class="mt-1 block w-full" v-model="form.phone" />
            </div>

            <div class="mt-4">
                <jet-label for="address" value="Indirizzo" />
                <jet-input id="address" type="text" class="mt-1 block w-full" v-model="form.address" />
            </div>

            <div class="mt-4">
                <jet-label for="cap" value="C.A.P" />
                <jet-input id="cap" type="text" class="mt-1 block w-full" v-model="form.cap" />
            </div>

            <div class="mt-4">
                <jet-label for="city" value="Città" />
                <jet-input id="city" type="text" class="mt-1 block w-full" v-model="form.city" />
            </div>

            <div class="mt-4">
                <jet-label for="prov" value="Provincia" />
                <jet-input id="prov" type="text" class="mt-1 block w-full" v-model="form.prov" />
            </div>

            <div class="mt-4">
                <jet-label for="password" value="Password *" />
                <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <jet-label for="password_confirmation" value="Confirm Password *" />
                <jet-input id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <jet-label for="agree">
                    <div class="flex items-center">
                        <jet-checkbox name="agree" id="agree" v-model:checked="form.agree" />

                        <div class="ml-2">
                            * Acconsento al trattamento dei miei dati personali
                        </div>
                    </div>
                </jet-label>
            </div>

            <div class="mt-4" v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature">
                <jet-label for="terms">
                    <div class="flex items-center">
                        <jet-checkbox name="terms" id="terms" v-model:checked="form.terms" />

                        <div class="ml-2">
                            I agree to the <a target="_blank" :href="route('terms.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Terms of Service</a> and <a target="_blank" :href="route('policy.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Privacy Policy</a>
                        </div>
                    </div>
                </jet-label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <inertia-link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
                    Sono già registrato?
                </inertia-link>

                <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Registrami
                </jet-button>
            </div>
        </form>
    </jet-authentication-card>
</template>

<script>
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo'
    import JetButton from '@/Jetstream/Button'
    import JetInput from '@/Jetstream/Input'
    import JetCheckbox from "@/Jetstream/Checkbox";
    import JetLabel from '@/Jetstream/Label'
    import JetValidationErrors from '@/Jetstream/ValidationErrors'


    export default {
        components: {
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors
        },
        data() {
            return {
                form: this.$inertia.form({
                    lastname: '',
                    name: '',
                    email: '',
                    birth: '',
                    natoa:'',
                    address: '',
                    city: '',
                    cap: '',
                    phone:'',
                    cfiscale: '',
                    prov: '',
                    agree:false,
                    password: '',
                    password_confirmation: '',
                    terms: false,
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('register'), {
                    onFinish: () => this.form.reset('password', 'password_confirmation'),
                })
            }
        }
    }
</script>
