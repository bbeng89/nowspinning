<template>
    <div>
        <!-- My Setup Fields -->
        <h1 class="text-center">Edit Profile</h1>
        <hr/>
        <h2 v-if="loading" class="text-center"><i class="fa fa-spinner fa-spin"></i></h2>
        <form v-else @submit.prevent="save">
            <legend>My Setup</legend>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="turntable" class="control-label">Turntable</label>
                        <input type="text" id="turntable" v-model="profile.turntable" class="form-control">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="turntable_cartridge" class="control-label">Turntable Cartridge</label>
                        <input type="text" id="turntable_cartridge" v-model="profile.turntable_cartridge" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="cd_player" class="control-label">CD Player</label>
                        <input type="text" id="cd_player" v-model="profile.cd_player" class="form-control">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="tape_deck" class="control-label">Tape Deck</label>
                        <input type="text" id="tape_deck" v-model="profile.tape_deck" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="amp_receiver" class="control-label">Amp/Receiver</label>
                        <input type="text" id="amp_receiver" v-model="profile.amp_receiver" class="form-control">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="preamp" class="control-label">Preamp</label>
                        <input type="text" id="preamp" v-model="profile.preamp" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="speakers" class="control-label">Speakers</label>
                        <input type="text" id="speakers" v-model="profile.speakers" class="form-control">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="subwoofer" class="control-label">Subwoofer</label>
                        <input type="text" id="subwoofer" v-model="profile.subwoofer" class="form-control">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="other" class="control-label">Notes/Other</label>
                <textarea id="other" v-model="profile.other" rows="5" class="form-control"></textarea>
            </div>
            <div v-if="profile.images.length > 0">
                <label class="control-label">Current Images</label>
                <div class="row">
                    <div v-for="image in profile.images" class="col-md-3">
                        <profile-image :image="image" @profile-image-deleted="removeImage">
                        </profile-image>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label">{{ uploadText }}</label>
                <vue-dropzone ref="profileVueDropzone" id="profileDropzone"
                    :options="dropzoneOptions"
                    @vdropzone-queue-complete="saveComplete"
                    @vdropzone-success="fileUploaded">
                </vue-dropzone>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success">
                    <i v-if="saving" class="fa fa-spinner fa-spin"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</template>
<script>
    import users from '../../api/users';
    import ProfileImage from './Profile-Image';
    import { mapState } from 'vuex';
    import vue2Dropzone from 'vue2-dropzone'
    import 'vue2-dropzone/dist/vue2Dropzone.css'

    export default {
        components: {
            vueDropzone: vue2Dropzone,
            profileImage: ProfileImage
        },
        data() {
            return {
                loading: false,
                saving: false,
                profile: {
                    images: [],
                    turntable: '',
                    turntable_cartridge: '',
                    cd_player: '',
                    tape_deck: '',
                    amp_receiver: '',
                    preamp: '',
                    speakers: '',
                    subwoofer: '',
                    other: ''
                },
                dropzoneOptions: {
                    url: '/api/user/profile/add-image',
                    autoProcessQueue: false,
                    thumbnailWidth: 150,
                    thumbnailHeight: 150,
                    addRemoveLinks: true,
                    acceptedFiles: '.jpg,.jpeg,.png,.bmp,.gif',
                    headers: {
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }
            }
        },
        mounted() {
            this.loading = true;
            users.getProfile(this.user.id, response => {
                this.profile = response.body;
                this.loading = false;
            });
        },
        methods: {
            save() {
                this.saving = true;
                users.updateProfile(this.profile, response => {
                    if(this.$refs.profileVueDropzone.getQueuedFiles().length > 0) {
                        this.$refs.profileVueDropzone.processQueue();
                    }
                    else {
                        this.saveComplete();
                    }
                });
            },
            saveComplete(){
                this.saving = false;
                this.$refs.profileVueDropzone.removeAllFiles();
                this.$notify({
                    title: 'Profile updated!',
                    text: 'Your profile was successfully updated',
                    type: 'success'
                });
            },
            fileUploaded(file, response){
                this.profile.images.push(response);
            },
            removeImage(image) {
                this.profile.images = this.profile.images.filter(img => img.id != image.id);
            }
        },
        computed: {
            uploadText(){
                return this.profile.images.length == 0
                    ? 'Add images of your setup'
                    : 'Upload additional images of your setup';
            },
            ...mapState({
                user: 'user'
            })
        }
    }
</script>