<template>
    <div>
        <div class="clearfix"></div>
        <div v-if="message" class="alert alert-danger alert-block mt-1">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <span class="lead">{{ message }}</span>
        </div>
        <h4>
            <p class="text-center py-2 h6">
                <strong>PASSWORD RECOVER BY SMS</strong>
            </p>
        </h4>
        <form @submit.prevent="submit" class="mb-3" id="loginForm" novalidate>
            <div class="form-group">
                <div class="input-group with-focus">
                    <input
                        name="reset_password_phone"
                        class="form-control border-right-0"
                        id="resetpwdsms"
                        type="text"
                        placeholder="Enter your Phone Number"
                        v-model="fields.reset_password_phone"
                    />
                    <div class="input-group-append">
                        <span
                            class="input-group-text text-muted bg-transparent border-left-0"
                        >
                            <em class="fa fa-phone"></em>
                        </span>
                    </div>
                </div>

                <div
                    v-if="errors && errors.reset_password_phone"
                    class="text-danger"
                >
                    {{ errors.reset_password_phone[0] }}
                </div>
            </div>
            <button class="btn btn-danger btn-block" type="submit">
                Reset Password
            </button>

            <div class="float-right">
                <a class="text-lg-right font-weight-bold" href="/"
                    >Back to Login</a
                >
            </div>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            fields: {},
            errors: {},
            success: false,
            loaded: true,
            loading: true,
            message: null
        };
    },
    mounted() {
        loading: false;
    },
    methods: {
        submit() {
            if (this.loaded) {
                this.loaded = false;
                this.success = false;
                this.errors = {};
                this.message = null;
                axios
                    .post("/api/auth/reset-password", this.fields)
                    .then(response => {
                        console.log(response.data);
                        this.fields = {}; //Clear input fields.
                        this.loaded = true;
                        this.success = true;

                        Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: 'Password recover successful !'
                    }).then(() => {
                        window.location = "/login";
                    });

                    })
                    .catch(error => {
                        this.loaded = true;

                        console.log(error);
                        if (error.response.status === 422) {
                            this.errors = error.response.data.errors || {};
                        } else if (error.response.status === 400) {
                            this.message = error.response.data.message;
                        }
                    });
            }
        }
    }
};
</script>
