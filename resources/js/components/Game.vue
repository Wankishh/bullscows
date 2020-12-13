<template>
    <div class="container">

        <md-dialog-alert
            :md-active.sync="modalOpened"
            md-title="System Message"
            :md-content="modalMessage" />


        <div class="md-layout">
            <div class="md-layout-item md-alignment-center">
                <img alt="Bulls&Cows :)" src="/img/bulls_and_cows.png" class="logo" />
            </div>
        </div>
        <div class="md-layout center-row">
            <div class="md-layout-item md-alignment-center">
                <h1>{{ hiddenKey }}</h1>
            </div>
        </div>
        <div class="md-layout center-row">
            <div class="md-layout-item md-alignment-center">
                <md-button class="md-raised md-primary" v-on:click="startGame()">New Game</md-button>
            </div>
        </div>
        <div class="md-layout center-row mb-3">
            <div class="md-layout-item md-alignment-center">
                <md-field>
                    <label>Enter Code</label>
                    <md-input v-model="modelVal" maxlength="4" type="number"></md-input>
                </md-field>
                <md-button class="md-raised md-primary" v-on:click="tryNew()">Try</md-button>
            </div>
        </div>
        <div class="md-layout" v-if="tries.length">
            <div class="md-layout-item md-alignment-center">
                <div class="table-height">
                    <md-table >
                        <md-table-row>
                            <md-table-head>input</md-table-head>
                            <md-table-head>bulls</md-table-head>
                            <md-table-head>cows</md-table-head>
                        </md-table-row>

                        <md-table-row v-for="value in tries" :key="value.input">
                            <md-table-cell>{{ value.input }}</md-table-cell>
                            <md-table-cell>{{ value.bulls }}</md-table-cell>
                            <md-table-cell>{{ value.cows }}</md-table-cell>
                        </md-table-row>
                    </md-table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import axios from "axios";

export default {
    name: 'Game',
    data() {
        return {
            tries: [],
            modelVal: "",
            hiddenKey: "? ? ? ?",
            modalOpened: false,
            modalMessage: "",
        }
    },
    methods: {
        startGame() {
            axios.post("/v1/new_game", {})
                .then(data => this.handleIncomingData(data.data))
                .catch(e => this.handleError(e));
        },
        tryNew() {
            axios.post("/v1/try_game", {
                input: this.modelVal
            })
                .then(data => this.handleIncomingData(data.data))
                .catch(this.handleError)
                .finally(() => {
                    this.modelVal = "";
                })
        },
        checkExistingGame() {
            axios.get("/v1/active_game_exists")
                .then(data => this.handleIncomingData(data.data))
        },
        handleIncomingData(data) {
            if (data.status === 1) {
                this.modalMessage = `You WON!!! The key was <strong>${data.key}</strong>!`;
                this.modalOpened = true;
            }

            this.tries = data.tries;
            this.hiddenKey = data.key;
        },
        handleError(error) {
            if (error && error.response) {
                const {data, status} = error.response;

                if (status === 422) {
                    const {errors} = data;
                    let firstError = '';
                    _.forIn(errors, (value) => {
                        if (!firstError && value[0]) {
                            firstError = value[0];
                        }
                    });

                    if (firstError) {
                        this.modalMessage = firstError;
                    }
                } else if (status === 500) {
                    this.modalMessage = "Problem! Please, try again.";
                }
            } else {
                this.modalMessage = "Problem! Please, try again.";
            }

            if(this.modalMessage) {
                this.modalOpened = true;
            }
        }
    },
    mounted() {
        this.checkExistingGame();
    }
}
</script>

<style scoped>
.container {
    max-width: 500px;
    margin: 20px auto;
}
.logo {
    max-width: 500px;
}

.center-row {
    text-align: center;
}

.mb-3 {
    margin-bottom: 10px;
}

.table-height {
    max-height: 350px;
    overflow: auto;
}
</style>
