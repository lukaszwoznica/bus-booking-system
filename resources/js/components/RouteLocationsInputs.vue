<template>
    <div>
        <div class="d-flex my-4">
            <div class="col-6 text-center">
                <h5>Locations</h5>
            </div>
            <div class="col-6 text-center">
                <h5>Minutes from departure</h5>
            </div>
        </div>

        <div class="form-group" v-for="(input, index) in inputs" :key="index">
            <div class="d-flex">
                <div class="col-6">
                    <select class="form-control custom-select"
                            :ref="`select2-${index}`"
                            :name="`locations[${index}][id]`"
                            :id="`location${index}`"
                            required>

                        <option></option>
                        <option v-for="location in locations" :value="location.id" :selected="input.id === location.id">
                            {{ location.name }}
                        </option>
                    </select>
                </div>

                <div class="col-4 col-lg-3 offset-md-1">
                    <input type="number" :name="`locations[${index}][minutes]`" v-show="index !== 0"
                           :disabled="index === 0"
                           class="form-control mr-2" placeholder="Minutes" v-model="input.minutes" min="0"
                           required>
                </div>

                <div class="col-3 d-flex align-items-center dynamic-inputs-buttons">
                    <i class="fas fa-minus text-danger fa-lg mr-2" @click="removeInput(index)"
                       v-show="index !== 0  && inputs.length > 2">
                    </i>
                    <i class="fas fa-plus text-success fa-lg" @click="addInput()"
                       v-show="index === inputs.length - 1">
                    </i>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'locations',
        'route'
    ],

    mounted() {
        if (this.route) {
            this.fillInputsWithRouteLocations(this.route.locations)
        } else {
            this.inputs.push({id: null, minutes: null}, {id: null, minutes: null})
        }

        this.applySelect2(0)
        this.applySelect2(1)
    },

    data() {
        return {
            inputs: []
        }
    },

    methods: {
        addInput() {
            this.inputs.push({id: null, minutes: null})
            this.applySelect2(this.inputs.length - 1)
        },

        removeInput(index) {
            this.inputs.splice(index, 1)
        },

        fillInputsWithRouteLocations(locations) {
            locations.forEach((location) => {
                this.inputs.push({
                    'id': location.pivot.location_id,
                    'minutes': location.pivot.minutes_from_departure
                })
            })
        },

        applySelect2(index) {
            this.$nextTick(() => {
                $(this.$refs[`select2-${index}`]).select2({
                    placeholder: 'Select location',
                    width: '100%'
                })
            })
        }
    }
}
</script>
