<template>
    <div class="container my-5">
        <h2>Attendance List</h2>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Attending</th>
                </tr>
                </thead>
                <tbody>
                <tr v-show="error">
                    <td colspan="3">{{ error }}</td>
                </tr>
                <tr v-show="!students.length">There are no students registered, please run the seeders.</tr>
                <tr v-for="student in students" :key="student.id">
                    <td>{{ student.id }}</td>
                    <td>{{ student.first_name }} {{ student.first_name }}</td>
                    <td>{{ student.email }}</td>
                    <td class="text-center">
                        <input type="checkbox" v-model="student.attending" @change="updateAttending(student, $event)"/>
                    </td>
                </tr>
                </tbody>
            </table>

            <button class="btn btn-dark" @click="saveChanges">Save changes</button>
        </div>
    </div>
</template>

<script>
export default {
    name: "Roster",
    data: function () {
        return {
            students: [],
            error: false,
        }
    },
    mounted() {
        this.getStudentsList();
    },
    methods: {
        async getStudentsList() {
            this.error = false;
            try {
                const {data: students} = await axios.get('/api/students');
                this.students = students;
            } catch (error) {
                this.error = error.response.data.message;
            }
        },
        updateAttending(updatedStudent, event) {
            this.students.find(student => student.id === updatedStudent.id).attending = event.target.checked;
        },
        async saveChanges() {
            try {
                const students = this.students.map(({id: student_id, attending: attended}) => {
                    return {student_id, attended};
                });
                const {data: {message}} = await axios.post('/api/students', {students});

                alert(message);
            } catch (error) {
                alert(error.response.data.message);
            }
        }
    }
}
</script>

<style scoped>

</style>
