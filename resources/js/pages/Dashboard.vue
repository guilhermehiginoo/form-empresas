<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'
import { Head, useForm } from '@inertiajs/vue3'
import { onMounted, ref, computed } from 'vue'
import axios from 'axios'

interface Category {
    id: number | string
    name: string
}

const companyForm = useForm({
    name: '',
    postcode: '',
    state: '',
    city: '',
    street: '',
    number: '',
    neighborhood: '',
    whatsapp_number: '',
    tax_id: '',
    category_id: '',
    new_category: '',
})

const categories = ref<Category[]>([])

onMounted(async () => {
    const { data } = await axios.get('/category/view')
    categories.value = data
})

const showNewCategoryInput = computed(() => companyForm.category_id === 'other')

const submitCompanyForm = () => {
    companyForm.post(route('company.store'), {
        preserveScroll: true,
        onSuccess: () => {
            companyForm.reset()
            alert('Empresa cadastrada com sucesso!')
        },
        onError: (errors) => {
            console.error('Erro ao cadastrar empresa:', errors)
        },
    })
}

const formContainerClasses =
    'p-6 sm:p-8 rounded-xl shadow-lg flex-1 bg-neutral-800 text-gray-100 border border-neutral-800'
const inputClasses =
    'w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:outline-none transition-colors duration-300 bg-zinc-700 border-gray-600 placeholder-gray-400 focus:ring-sky-500 focus:border-sky-500 text-white'
const labelClasses = 'block mb-2 text-sm font-medium text-gray-300'
const buttonClasses =
    'w-full px-6 py-3 text-base font-medium rounded-lg focus:ring-4 focus:outline-none transition-colors duration-300 bg-sky-600 hover:bg-sky-700 focus:ring-sky-800 text-white'
const fieldsetLegendClasses = 'text-lg font-medium px-1 text-gray-200'
const fieldsetBorderClasses = 'border-zinc-700'

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Cadastro de Empresa', href: '/dashboard' }]
</script>


<template>
    <Head title="Cadastro de Empresa" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div :class="formContainerClasses">
                <h2 class="text-2xl font-semibold mb-6 text-white">Cadastrar Nova Empresa</h2>
                <form @submit.prevent="submitCompanyForm" class="space-y-6">
                    <div>
                        <label for="company-name" :class="labelClasses">Nome da Empresa *</label>
                        <input
                            type="text"
                            id="company-name"
                            v-model="companyForm.name"
                            :class="inputClasses"
                            placeholder="Nome Completo da Empresa"
                            required
                        />
                        <p v-if="companyForm.errors.name" class="mt-1 text-xs text-red-500">
                            {{ companyForm.errors.name }}
                        </p>
                    </div>

                    <div>
                        <label for="company-tax_id" :class="labelClasses">CNPJ/CPF *</label>
                        <input
                            type="text"
                            id="company-tax_id"
                            v-model="companyForm.tax_id"
                            :class="inputClasses"
                            placeholder="00.000.000/0001-00 ou 000.000.000-00"
                            required
                        />
                        <p v-if="companyForm.errors.tax_id" class="mt-1 text-xs text-red-500">
                            {{ companyForm.errors.tax_id }}
                        </p>
                    </div>

                    <fieldset class="border p-4 rounded-md" :class="fieldsetBorderClasses">
                        <legend :class="fieldsetLegendClasses">Endereço *</legend>
                        <div class="space-y-4 mt-2">
                            <div>
                                <label for="company-postcode" :class="labelClasses">CEP *</label>
                                <input
                                    type="text"
                                    id="company-postcode"
                                    v-model="companyForm.postcode"
                                    :class="inputClasses"
                                    placeholder="00000-000"
                                    required
                                />
                                <p v-if="companyForm.errors.postcode" class="mt-1 text-xs text-red-500">
                                    {{ companyForm.errors.postcode }}
                                </p>
                            </div>

                            <div>
                                <label for="company-street" :class="labelClasses">Rua *</label>
                                <input
                                    type="text"
                                    id="company-street"
                                    v-model="companyForm.street"
                                    :class="inputClasses"
                                    placeholder="Av. Brasil"
                                    required
                                />
                                <p v-if="companyForm.errors.street" class="mt-1 text-xs text-red-500">
                                    {{ companyForm.errors.street }}
                                </p>
                            </div>

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                                <div>
                                    <label for="company-number" :class="labelClasses">Número *</label>
                                    <input
                                        type="text"
                                        id="company-number"
                                        v-model="companyForm.number"
                                        :class="inputClasses"
                                        placeholder="123B"
                                        required
                                    />
                                    <p v-if="companyForm.errors.number" class="mt-1 text-xs text-red-500">
                                        {{ companyForm.errors.number }}
                                    </p>
                                </div>
                                <div class="sm:col-span-2">
                                    <label for="company-neighborhood" :class="labelClasses">Bairro *</label>
                                    <input
                                        type="text"
                                        id="company-neighborhood"
                                        v-model="companyForm.neighborhood"
                                        :class="inputClasses"
                                        placeholder="Centro"
                                        required
                                    />
                                    <p v-if="companyForm.errors.neighborhood" class="mt-1 text-xs text-red-500">
                                        {{ companyForm.errors.neighborhood }}
                                    </p>
                                </div>
                            </div>

                            <div>
                                <label for="company-city" :class="labelClasses">Cidade *</label>
                                <input
                                    type="text"
                                    id="company-city"
                                    v-model="companyForm.city"
                                    :class="inputClasses"
                                    placeholder="Sua Cidade"
                                    required
                                />
                                <p v-if="companyForm.errors.city" class="mt-1 text-xs text-red-500">
                                    {{ companyForm.errors.city }}
                                </p>
                            </div>

                            <div>
                                <label for="company-state" :class="labelClasses">Estado *</label>
                                <input
                                    type="text"
                                    id="company-state"
                                    v-model="companyForm.state"
                                    :class="inputClasses"
                                    placeholder="UF (ex: SP)"
                                    required
                                    maxlength="2"
                                />
                                <p v-if="companyForm.errors.state" class="mt-1 text-xs text-red-500">
                                    {{ companyForm.errors.state }}
                                </p>
                            </div>
                        </div>
                    </fieldset>

                    <div>
                        <label for="company-whatsapp_number" :class="labelClasses">Número do WhatsApp *</label>
                        <input
                            type="tel"
                            id="company-whatsapp_number"
                            v-model="companyForm.whatsapp_number"
                            :class="inputClasses"
                            placeholder="(00) 90000-0000"
                            required
                        />
                        <p v-if="companyForm.errors.whatsapp_number" class="mt-1 text-xs text-red-500">
                            {{ companyForm.errors.whatsapp_number }}
                        </p>
                    </div>

                    <!-- Campo Categoria -->
                    <div>
                        <label for="company-category" :class="labelClasses">Categoria *</label>
                        <select
                            id="company-category"
                            v-model="companyForm.category_id"
                            :class="inputClasses"
                            required
                        >
                            <option value="" disabled>Selecione uma categoria</option>
                            <option v-for="category in categories" :key="category.id" :value="category.id">
                                {{ category.name }}
                            </option>
                            <option value="other">Outra</option>
                        </select>
                        <p v-if="companyForm.errors.category_id" class="mt-1 text-xs text-red-500">
                            {{ companyForm.errors.category_id }}
                        </p>
                    </div>

                    <!-- Input para nova categoria aparece só se escolher "other" -->
                    <div v-if="showNewCategoryInput">
                        <label for="company-new-category" :class="labelClasses">Nome da Nova Categoria *</label>
                        <input
                            type="text"
                            id="company-new-category"
                            v-model="companyForm.new_category"
                            :class="inputClasses"
                            placeholder="Digite o nome da nova categoria"
                            required
                        />
                        <p v-if="companyForm.errors.new_category" class="mt-1 text-xs text-red-500">
                            {{ companyForm.errors.new_category }}
                        </p>
                    </div>

                    <div>
                        <button
                            type="submit"
                            :disabled="companyForm.processing"
                            :class="buttonClasses"
                        >
                            <span v-if="companyForm.processing">Salvando...</span>
                            <span v-else>Cadastrar Empresa</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
input:disabled {
    cursor: not-allowed;
    opacity: 0.7
}
</style>
