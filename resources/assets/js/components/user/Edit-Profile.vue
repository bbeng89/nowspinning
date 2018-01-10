<template>
    <div>
        <!-- My Setup Fields -->
        <h1 class="text-center">Edit Profile</h1>
        <hr/>
        <h2 v-if="loading" class="text-center"><i class="fa fa-spinner fa-spin"></i></h2>
        <form v-else @submit.prevent="save">
            <legend>My Setup</legend>
            <div class="form-group">
                <label for="turntable" class="control-label">Turntable</label>
                <input type="text" id="turntable" v-model="profile.turntable" class="form-control">
            </div>
            <div class="form-group">
                <label for="turntable_cartridge" class="control-label">Turntable Cartridge</label>
                <input type="text" id="turntable_cartridge" v-model="profile.turntable_cartridge" class="form-control">
            </div>
            <div class="form-group">
                <label for="cd_player" class="control-label">CD Player</label>
                <input type="text" id="cd_player" v-model="profile.cd_player" class="form-control">
            </div>
            <div class="form-group">
                <label for="tape_deck" class="control-label">Tape Deck</label>
                <input type="text" id="tape_deck" v-model="profile.tape_deck" class="form-control">
            </div>
            <div class="form-group">
                <label for="amp_receiver" class="control-label">Amp/Receiver</label>
                <input type="text" id="amp_receiver" v-model="profile.amp_receiver" class="form-control">
            </div>
            <div class="form-group">
                <label for="preamp" class="control-label">Preamp</label>
                <input type="text" id="preamp" v-model="profile.preamp" class="form-control">
            </div>
            <div class="form-group">
                <label for="speakers" class="control-label">Speakers</label>
                <input type="text" id="speakers" v-model="profile.speakers" class="form-control">
            </div>
            <div class="form-group">
                <label for="subwoofer" class="control-label">Subwoofer</label>
                <input type="text" id="subwoofer" v-model="profile.subwoofer" class="form-control">
            </div>
            <div class="form-group">
                <label for="other" class="control-label">Notes/Other</label>
                <textarea id="other" v-model="profile.other" rows="5" class="form-control"></textarea>
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
    import { mapState } from 'vuex';

    export default {
        data() {
            return {
                profile: {
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
                loading: false,
                saving: false
            }
        },
        mounted() {
            this.loading = true;
            users.getProfile(this.user.id, response => {
                let profile = response.body;
                this.profile.turntable = profile.turntable;
                this.profile.turntable_cartridge = profile.turntable_cartridge;
                this.profile.cd_player = profile.cd_player;
                this.profile.tape_deck = profile.tape_deck;
                this.profile.amp_receiver = profile.amp_receiver;
                this.profile.preamp = profile.preamp;
                this.profile.speakers = profile.speakers;
                this.profile.subwoofer = profile.subwoofer;
                this.profile.other = profile.other;
                this.loading = false;
            });
        },
        methods: {
            save() {
                this.saving = true;
                users.updateProfile(this.profile, response => this.saving = false);
            }
        },
        computed: {
            ...mapState({
                user: 'user'
            })
        }
    }
</script>