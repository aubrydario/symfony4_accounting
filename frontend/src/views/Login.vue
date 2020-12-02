<template>
    <div>
        <div class="login-background"></div>
        <div class="login-box">
            <h1>Login</h1>
            <v-form v-model="valid">
                <v-row>
                    <v-col>
                        <v-text-field
                            v-model="username"
                            label="Benutzername"
                            prepend-icon="fas fa-user"
                            required
                        ></v-text-field>
                        <v-text-field
                            v-model="password"
                            type="password"
                            label="Passwort"
                            prepend-icon="fas fa-lock"
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
                        >Einloggen</v-btn>
                    </v-col>
                </v-row>
            </v-form>
            <v-row class="justify-center">
                <p>
                    Noch kein Account?
                    <router-link to="/register">Hier registrieren</router-link>
                </p>
            </v-row>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'Login',
        data: () => ({
            valid: false,
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
