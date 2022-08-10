<template>
    <div id="asistencia" class="section section-small section-get-started">
        <div class="parallax filter">
            <!-- <div
                class="image"
                style="background-image: url('img/office-2.jpg')"
            ></div> -->
            <div class="container">
                <div class="title-area">
                    <h2 class="">Confirma tu asistencia</h2>
                    <div class="separator separator-gold">✻</div>
                </div>
                <div v-if="continueAttendee === ''">
                    <div class="card pt-5 pb-5">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 col-12 justify-content-center">
                                <div class="card-body">
                                    <div class="mb-4">
                                        <div class="form-group mb-4 text-left">
                                            <label
                                                for="name"
                                                class="form-control-label text-primary"
                                                >Nombre</label
                                            >
                                            <input
                                                type="text"
                                                id="name"
                                                name="name"
                                                for="name"
                                                v-model="Name"
                                                class="form-control border-top-0 border-end-0 border-start-0 border-primary"
                                            />
                                            <p
                                                v-if="errorName !== ''"
                                                class="text-danger text-left"
                                            >
                                                <b>{{ errorName }}</b>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="form-group text-left">
                                            <label
                                                for="email"
                                                class="form-control-label text-primary"
                                                >Correo electronico</label
                                            >
                                            <input
                                                type="email"
                                                id="email"
                                                name="email"
                                                v-model="Email"
                                                class="form-control border-top-0 border-end-0 border-start-0 border-primary"
                                            />
                                            <p
                                                v-if="errorEmail !== ''"
                                                class="text-danger text-left"
                                            >
                                                <b>{{ errorEmail }}</b>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="form-group text-left">
                                            <label
                                                class="form-control-label text-primary"
                                                >Asistentes</label
                                            >
                                            <input
                                                type="number"
                                                id="attendee"
                                                name="attendee"
                                                v-model="Attendee"
                                                class="form-control border-top-0 border-end-0 border-start-0 border-primary"
                                            />
                                            <p
                                                v-if="errorAttendee !== ''"
                                                class="text-danger text-left"
                                            >
                                                <b>{{ errorAttendee }}</b>
                                            </p>
                                        </div>
                                    </div>

                                    <div
                                        v-if="!loadingAttendee"
                                        class="col-12 pt-3 text-center"
                                    >
                                        <button
                                            :class="'btn btn-primary'"
                                            @click="createAttendee($event)"
                                        >
                                            Crear
                                        </button>
                                    </div>
                                    <div v-else class="col-12 pt-3 text-center">
                                        <i class="fas fa-cog fa-2x fa-spin"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Alerta de éxito -->
                <div v-else class="">
                    <div class="card pt-5 pb-5">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 col-12 justify-content-center">
                                <div class="card-body">
                                    <div class="row justify-content-center">
                                        <div
                                            class="col-12 text-primary text-center"
                                        >
                                            <h3>
                                                Gracias por confirmar tu
                                                asistencia
                                            </h3>
                                        </div>
                                    </div>
                                    <a
                                        href="#asistencia"
                                        @click="clearAttendee($event)"
                                        ><i class="fas fa-times text-danger"></i
                                    ></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            Name: "",
            errorName: "",
            Email: "",
            errorEmail: "",
            Attendee: "",
            errorAttendee: "",

            flagAttemdee: false,

            continueAttendee: "",
            loadingAttendee: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        };
    },
    methods: {
        createAttendee($e) {
            this.errorName = "";
            this.errorEmail = "";
            this.errorAttendee = "";

            if (this.Name.trim() === "") {
                this.errorName = "Nombre vacio!";
            }

            if (!this.Email) {
                this.errorEmail = "El email está vacio.";
            } else if (!this.validEmail(this.Email)) {
                this.errorEmail = "Email valido requerido aaa@aaa.aaa";
            }

            if (this.Attendee.trim() <= 0) {
                this.errorAttendee = "El número de asistentes no puede ser 0";
            }

            if (
                this.errorName !== "" ||
                this.errorEmail !== "" ||
                this.errorAttendee !== ""
            ) {
                return !1;
            }

            this.loadingAttendee = true;
            // console.log($($e))

            axios
                .post("/store", {
                    name: this.Name.trim(),
                    email: this.Email.trim(),
                    attendee: this.Attendee.trim(),
                })
                .then((res) => {
                    if (res.data.msg === "success") {
                        this.continueAttendee = "success";
                        // this.startComponent();
                    } else {
                        this.errorName = res.data.name;
                        this.errorEmail = res.data.email;
                        this.errorAttendee = res.data.attendee;
                    }
                })
                .catch((error) => {
                    this.errorName = error.response.data.errors.name;
                    this.errorEmail = error.response.data.errors.email;
                    this.errorAttendee = error.response.data.errors.attendee;
                })
                .finally((fin) => {
                    this.loadingAttendee = false;
                });
        },
        clearAttendee(e) {
            this.Name = "";
            this.Email = "";
            this.Attendee = "";
            this.continueAttendee = "";
        },
        validEmail: function (email) {
            var re =
                /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        },
    },
    mounted() {
        console.log("Component mounted.");
    },
};
</script>
