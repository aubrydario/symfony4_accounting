<template>
    <div>
        <div class="login-background"></div>
        <div class="login-box">
            <h1>Registrieren</h1>
            <v-form v-model="valid">
                <v-row>
                    <v-col>
                        <v-text-field
                            v-model="firstname"
                            label="Vorname"
                            required
                        ></v-text-field>
                        <v-text-field
                            v-model="lastname"
                            label="Nachname"
                            required
                        ></v-text-field>
                        <v-text-field
                            v-model="email"
                            type="email"
                            label="Email"
                            required
                        ></v-text-field>
                        <v-text-field
                            v-model="username"
                            label="Benutzername"
                            required
                        ></v-text-field>
                        <v-text-field
                            v-model="password"
                            type="password"
                            label="Passwort"
                            required
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col class="d-flex justify-center">
                        <v-btn
                            class="my-5"
                            color="success"
                            @click="validate"
                            rounded
                        >Registrieren</v-btn>
                    </v-col>
                </v-row>
            </v-form>
            <v-row class="justify-center">
                <p>
                    Haben Sie bereits einen Account?
                    <router-link to="/login">Hier einloggen</router-link>
                </p>
            </v-row>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'Register',
        data: () => ({
            valid: false,
            firstname: '',
            lastname: '',
            email: '',
            username: '',
            password: '',
        }),
        methods: {
            validate() {

            }
        }
    };
</script>
<style lang="scss" scoped>
    .login-background {
        background-image: url(../assets/mountains.jpg);
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
        height: 100vh;
        width: 100%;
        filter: blur(8px)
    }
    .login-box {
        background: rgba(255, 255, 255, 0.5);
        box-shadow: 0 0 20px;
        position: absolute;
        top: 20%;
        left: 50%;
        margin-left: -200px;
        width: 400px;
        padding: 20px;

        h1 {
            text-align: center;
            margin: 20px 0;
        }
    }
</style>
