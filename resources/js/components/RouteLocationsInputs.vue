<template>
    <div>
        <div class="d-flex my-4">
            <div class="col-6 text-center">
                <h5>Locations</h5>
            </div>
            <div class="col-6 text-center">
                <h5>Estimated time from departure</h5>
            </div>
        </div>

        <div class="form-group" v-for="(input, index) in inputs" :key="index">
            <div class="d-flex">
                <select class="form-control col-6"
                        :name="`locations[${index}][id]`"
                        :id="`location${index}`"
                        required>

                    <option value="" hidden>Choose location</option>
                    <option v-for="location in locations" :value="location.id" :selected="input.id === location.id">
                        {{ location.name }}
                    </option>
                </select>

                <input type="number" :name="`locations[${index}][minutes]`" v-show="index !== 0" :disabled="index === 0"
                       class="form-control col-3 offset-1" placeholder="Minutes" v-model="input.minutes" min="0" required>

                <div class="col-3">
                    <i class="btn btn-danger" @click="removeInput(index)"
                       v-show="index !== 0  && inputs.length > 2">-</i>
                    <i class="btn btn-primary" @click="addInput()"
                       v-show="index === inputs.length - 1">+</i>
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
            this.inputs.push( {id: null, minutes: null}, {id: null, minutes: null} )
        }
    },

    data() {
        return {
            inputs: []
        }
    },

    methods: {
        addInput() {
            this.inputs.push( {id: null, minutes: null} );
            console.log(this.inputs)
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
        }
    }
}
</script>
