<template>
    <div id="asistencia-list" class="section section-small section-get-started">
        <div class="container">
            <div class="title-area text-gray">
                <h2 class="">Confirmados</h2>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive tableFixHead">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th
                                        class="text-uppercase text-gray text-sm font-weight-bolder opacity-10"
                                    >
                                        Nombre
                                    </th>
                                    <th
                                        class="text-uppercase text-gray text-sm font-weight-bolder opacity-10 ps-2"
                                    >
                                        E-mail
                                    </th>
                                    <th
                                        class="text-uppercase text-gray text-sm font-weight-bolder opacity-10 ps-2"
                                    >
                                        Asistentes
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(attendee, index) in attendees"
                                    :key="index"
                                >
                                    <td>
                                        <p
                                            class="text-xs text-gray font-weight-bold text-left"
                                        >
                                            {{ attendee.Name }}
                                        </p>
                                    </td>
                                    <td>
                                        <p
                                            class="text-xs text-gray font-weight-bold text-left"
                                        >
                                            {{ attendee.Email }}
                                        </p>
                                    </td>
                                    <td>
                                        <p
                                            class="text-xs text-gray font-weight-bold text-left"
                                        >
                                            {{ attendee.Attendee }}
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row text-gray justify-content-center">
                        <div class="col-8"><h4>Total:</h4></div>
                        <div class="col-4">
                            <h4>{{ total }}</h4>
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
            attendees: [],
            total: "",

            flagAttemdee: false,

            continueAttendee: "",
            loadingAttendee: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        };
    },
    methods: {
        startComponent() {
            axios.get("/dashboard").then((res) => {
                this.attendees = res.data.attendees;
                this.total = res.data.total;
                console.log(this.total);
            });
        },
    },
    mounted() {
        console.log("Component mounted.");
        this.startComponent();
    },
};
</script>
