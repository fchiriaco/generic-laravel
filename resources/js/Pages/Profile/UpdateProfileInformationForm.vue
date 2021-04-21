<template>
    <jet-form-section @submitted="updateProfileInformation">
        <template #title>
            Profilo Utente
        </template>

        <template #description>
            Aggiorna il tuo profilo utente.
        </template>

        <template #form>
            <!-- Profile Photo -->
            <div class="col-span-6 sm:col-span-4" v-if="$page.props.jetstream.managesProfilePhotos">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden"
                            ref="photo"
                            @change="updatePhotoPreview">

                <jet-label for="photo" value="Photo" />

                <!-- Current Profile Photo -->
                <div class="mt-2" v-show="! photoPreview">
                    <img :src="user.profile_photo_url" :alt="user.name" class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" v-show="photoPreview">
                    <span class="block rounded-full w-20 h-20"
                          :style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <jet-secondary-button class="mt-2 mr-2" type="button" @click.prevent="selectNewPhoto">
                    Seleziona una foto
                </jet-secondary-button>

                <jet-secondary-button type="button" class="mt-2" @click.prevent="deletePhoto" v-if="user.profile_photo_path">
                    Rimuovi foto
                </jet-secondary-button>

                <jet-input-error :message="form.errors.photo" class="mt-2" />
            </div>

            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="lastname" value="Cognome *" />
                <jet-input id="lastname" type="text" class="mt-1 block w-full" v-model="form.lastname" autocomplete="lastname" />
                <jet-input-error :message="form.errors.name" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="Nome *" />
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" />
                <jet-input-error :message="form.errors.name" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="birth" value="Data nascita" />
                <jet-input id="birth" type="date" class="mt-1 block w-full" v-model="form.birth" />
                <jet-input-error :message="form.errors.birth" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="natoa" value="Luogo nascita" />
                <jet-input id="natoa" type="text" class="mt-1 block w-full" v-model="form.natoa" />
                <jet-input-error :message="form.errors.natoa" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="cfiscale" value="P.Iva/Cod. Fiscale" />
                <jet-input id="cfiscale" type="text" class="mt-1 block w-full" v-model="form.cfiscale" />
                <jet-input-error :message="form.errors.cfiscale" class="mt-2" />
            </div>
            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="email" value="Email *" />
                <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" />
                <jet-input-error :message="form.errors.email" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="phone" value="Telefono" />
                <jet-input id="phone" type="text" class="mt-1 block w-full" v-model="form.phone" />
                <jet-input-error :message="form.errors.phone" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="address" value="Indirizzo" />
                <jet-input id="address" type="text" class="mt-1 block w-full" v-model="form.address" />
                <jet-input-error :message="form.errors.address" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="cap" value="C.A.P." />
                <jet-input id="cap" type="text" class="mt-1 block w-full" v-model="form.cap" />
                <jet-input-error :message="form.errors.cap" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="city" value="Città" />
                <jet-input id="city" type="text" class="mt-1 block w-full" v-model="form.city" />
                <jet-input-error :message="form.errors.city" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="prov" value="Provincia" />
                <jet-input id="prov" type="text" class="mt-1 block w-full" v-model="form.prov" />
                <jet-input-error :message="form.errors.prov" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Dati salvati correttamente.
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                SALVA
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
    import JetButton from '@/Jetstream/Button'
    import JetFormSection from '@/Jetstream/FormSection'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'

    export default {
        components: {
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetSecondaryButton,
        },

        props: ['user'],

        data() {
            return {
                form: this.$inertia.form({
                    _method: 'PUT',
                    lastname: this.user.lastname,
                    name: this.user.name,
                    birth: this.user.birth,
                    natoa: this.user.natoa,
                    cfiscale: this.user.cfiscale,
                    email: this.user.email,
                    phone:this.user.phone,
                    address: this.user.address,
                    cap:this.user.cap,
                    city: this.user.city,
                    prov: this.user.prov,
                    photo: this.user.photo,
                }),

                photoPreview: true,
            }
        },

        methods: {
            updateProfileInformation() {
                if (this.$refs.photo) {
                    this.form.photo = this.$refs.photo.files[0]
                }

                this.form.post(route('user-profile-information.update'), {
                    errorBag: 'updateProfileInformation',
                    preserveScroll: true
                });
            },

            selectNewPhoto() {
                this.$refs.photo.click();
            },

            updatePhotoPreview() {
                const reader = new FileReader();

                reader.onload = (e) => {
                    this.photoPreview = e.target.result;
                };

                reader.readAsDataURL(this.$refs.photo.files[0]);
            },

            deletePhoto() {
                this.$inertia.delete(route('current-user-photo.destroy'), {
                    preserveScroll: true,
                    onSuccess: () => (this.photoPreview = null),
                });
            },
        },
    }
</script>
