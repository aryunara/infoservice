<template>
    <main class="main-form">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-14">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-center">Список лидов</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <p><strong>Общее количество лидов:</strong> {{ localLeads.length }}</p>
                                <p v-for="status in orderedStatuses" :key="status.id">
                                    <strong>Лидов со статусом "{{ status.title }}":</strong> {{ leadsCountInStatuses[status.title] ?? 0 }}
                                </p>
                            </div>

                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Имя</th>
                                    <th>Фамилия</th>
                                    <th>Электронная почта</th>
                                    <th>Телефон</th>
                                    <th>Дата создания</th>
                                    <th>Статус</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="lead in orderedLeads" :key="lead.id">
                                    <td>{{ lead.id }}</td>
                                    <td>
                                        <input
                                            type="text"
                                            v-model="lead.name"
                                            @input="markAsChanged"
                                            class="form-control"
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            v-model="lead.surname"
                                            @input="markAsChanged"
                                            class="form-control"
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="email"
                                            v-model="lead.email"
                                            @input="markAsChanged"
                                            class="form-control"
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="tel"
                                            v-model="lead.phone"
                                            @input="markAsChanged"
                                            class="form-control"
                                        />
                                    </td>
                                    <td>
                                        {{ new Date(lead.created_at).toLocaleDateString('ru-RU',
                                        { day: '2-digit', month: '2-digit', year: 'numeric' }
                                    ) }}
                                    </td>
                                    <td>
                                        <select
                                            class="form-control status-dropdown"
                                            v-model="lead.status_id"
                                            @change="updateStatus(lead.id, lead.status_id)"
                                        >
                                            <option v-for="status in orderedStatuses" :key="status.id" :value="status.id">
                                                {{ status.title }}
                                            </option>
                                        </select>
                                    </td>
                                    <td>
                                        <button @click="deleteLead(lead.id)" class="btn btn-danger btn-sm">Удалить</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            <div class="d-grid mx-auto mt-3">
                                <button
                                    @click="saveChanges"
                                    class="btn btn-save" style="background-color: #006699; color: white;"
                                    :disabled="!changesMade"
                                >
                                    Сохранить изменения
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import axios from "axios";
export default {
    name: 'LeadComponent',
    props: {
        leads: {
            type: Array,
            required: true
        },
        statuses: {
            required: true
        },
    },
    data() {
        return {
            localLeads: [...this.leads],
            leadsCountInStatuses: {},
            changesMade: false, // Флаг для отслеживания изменений
        };
    },
    computed: {
        orderedStatuses() {
            return this.statuses.slice().sort((a, b) => a.id - b.id);
        },
        orderedLeads() {
            return this.localLeads.slice().sort((a, b) => a.id - b.id);
        }
    },
    methods: {
        markAsChanged() {
            this.changesMade = true; // Устанавливаем флаг изменений при редактировании
        },
        updateStatus(leadId, newStatusId) {
            axios.post('api/updateStatus/' + leadId + '/' + newStatusId)
                .then(response => {
                    if (response.data.success) {
                        const lead = this.localLeads.find(lead => lead.id === leadId);
                        if (lead) {
                            lead.status_id = newStatusId;
                            this.updateLeadsCountInStatuses();
                        }
                    } else {
                        console.error(response.data.message);
                    }
                })
                .catch(error => {
                    console.error("Error while updating status", error);
                });
        },
        updateLeadsCountInStatuses() {
            const counts = {};

            this.localLeads.forEach(lead => {
                const leadStatus = this.statuses.find(status => status.id === lead.status_id);
                if (leadStatus) {
                    const statusTitle = leadStatus.title;
                    counts[statusTitle] = counts[statusTitle] ? counts[statusTitle] + 1 : 1;
                }
            });

            this.leadsCountInStatuses = counts;
        },
        deleteLead(leadId) {
            axios.post('api/deleteLead/' + leadId)
                .then(response => {
                    if (response.data.success) {
                        this.localLeads = this.localLeads.filter(lead => lead.id !== leadId);
                        this.updateLeadsCountInStatuses();
                    } else {
                        console.error(response.data.message);
                    }
                })
                .catch(error => {
                    console.error("Error while deleting the lead", error);
                });
        },
        saveChanges() {
            const updates = this.localLeads.map((lead) => ({
                id: lead.id,
                name: lead.name,
                surname: lead.surname,
                email: lead.email,
                phone: lead.phone
            }));

            axios.post('api/updateLeads', updates)
                .then(response => {
                    if (response.data.success) {
                        this.changesMade = false;
                        this.updateLeadsCountInStatuses();
                    } else {
                        console.error(response.data.message);
                    }
                })
                .catch(error => {
                    console.error("Error while saving changes", error);
                });
        }
    },
    created() {
        this.updateLeadsCountInStatuses();
    }
}
</script>

<style>
.card {
    width: 1400px;
}
.table {
    width: 100%; /* Делает таблицу шире */
}

.table th, .table td {
    overflow: hidden; /* Скрывает переполнение */
    text-overflow: ellipsis; /* Добавляет многоточие для длинных текстов */
    white-space: nowrap; /* Запрещает перенос строк */
}
.btn-save {
    width: 200px;
}
</style>
