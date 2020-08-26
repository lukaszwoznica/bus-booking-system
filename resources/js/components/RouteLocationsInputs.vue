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

        <div class="form-group">
            <label for="location0">Departure location</label>
            <div class="d-flex">
                <select class="form-control col-6" id="location0" name="locations[0][id]" required>
                    <option value="" selected hidden>Choose location</option>
                    <option v-for="location in locations" :value="location.id">
                        {{ location.name }}
                    </option>
                </select>
            </div>
        </div>

        <div class="form-group" v-for="(input, index) in inputs" :key="index">
            <label :for="`location${index + 1}`" v-show="index + 1 === inputs.length">
                Arrival location
            </label>
            <div class="d-flex">
                <select class="form-control col-6"
                        :name="`locations[${index + 1}][id]`"
                        :id="`location${index + 1}`"
                        required>

                    <option value="" selected disabled hidden>Choose location</option>
                    <option v-for="location in locations" :value="location.id">
                        {{ location.name }}
                    </option>

                </select>

                <input type="number" :name="`locations[${index + 1}][minutes]`" min="0"
                       class="form-control col-3 offset-1" placeholder="Minutes" required>

                <div class="col-3">
                    <i class="btn btn-danger" @click="removeInput(index)"
                       v-show="index || (! index && inputs.length > 1)">-</i>
                    <i class="btn btn-primary" @click="addInput()"
                       v-show="index === inputs.length - 1">+</i>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        axios.get('/api/locations')
            .then(response => {
                this.locations = response.data.data;
            });
    },

    data() {
        return {
            locations: null,
            inputs: [{}]
        }
    },

    methods: {
        addInput() {
            this.inputs.push({});
        },

        removeInput(index) {
            this.inputs.splice(index, 1)
        }
    }
}
</script>
