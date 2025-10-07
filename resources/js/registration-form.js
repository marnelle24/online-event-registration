// Registration Form Alpine.js Component
document.addEventListener('alpine:init', () => {
    Alpine.data('registrationForm', (config) => ({
        // State Management
        currentStep: config.user ? 2 : 1,
        totalSteps: config.allowGroupRegistration ? 5 : 4,
        allowGroupRegistration: config.allowGroupRegistration,
        groupRegistrationMin: config.groupRegistrationMin,
        groupRegistrationMax: config.groupRegistrationMax,
        groupRegIndividualFee: config.groupRegIndividualFee,
        programmePrice: config.programmePrice,
        
        // Form State
        validating: false,
        submitting: false,
        promocodeError: '',
        promocodeValid: false,
        discountAmount: 0,
        finalPrice: config.programmePrice,
        isGroupRegistration: false,
        groupMembers: [],
        
        // Form Data
        formData: {
            programmeCode: config.programmeCode,
            programmeId: config.programmeId,
            promocode: '',
            promocodeId: null,
            registrationType: config.user ? 'guest' : '',
            title: config.userTitle || '',
            firstName: config.userFirstName || '',
            lastName: config.userLastName || '',
            nric: '',
            email: config.userEmail || '',
            contactNumber: '',
            address: '',
            city: '',
            postalCode: ''
        },

        // Navigation Methods
        nextStep() {
            // Skip step 3 if not group registration
            if (this.currentStep === 2 && !this.isGroupRegistration && this.allowGroupRegistration) {
                this.currentStep = 4; // Skip to promo code step
            } else if (this.currentStep < this.totalSteps) {
                this.currentStep++;
            }
        },

        previousStep() {
            // Skip step 3 if not group registration when going back
            if (this.currentStep === 4 && !this.isGroupRegistration && this.allowGroupRegistration) {
                this.currentStep = 2; // Go back to registration info step
            } else if (this.currentStep > 1) {
                this.currentStep--;
            }
        },

        // Group Registration Methods
        addGroupMember() {
            if (this.groupMembers.length < this.groupRegistrationMax - 1) {
                this.groupMembers.push({
                    title: '',
                    firstName: '',
                    lastName: '',
                    nric: '',
                    email: '',
                    contactNumber: ''
                });
            }
        },

        removeGroupMember(index) {
            this.groupMembers.splice(index, 1);
        },

        canProceedGroupStep() {
            if (!this.isGroupRegistration) return true;
            
            const totalMembers = this.groupMembers.length + 1; // +1 for main registrant
            return totalMembers >= this.groupRegistrationMin && totalMembers <= this.groupRegistrationMax;
        },

        // Form Validation Methods
        isMainRegistrantValid() {
            // Check if required fields for main registrant are filled
            return this.formData.title && 
                   this.formData.title.trim() !== '' &&
                   this.formData.firstName && 
                   this.formData.firstName.trim() !== '' &&
                   this.formData.lastName && 
                   this.formData.lastName.trim() !== '' &&
                   this.formData.email && 
                   this.formData.email.trim() !== '' &&
                   this.formData.contactNumber && 
                   this.formData.contactNumber.trim() !== '';
        },

        canCompleteRegistration() {
            // Check if main registrant is valid and not currently submitting
            return this.isMainRegistrantValid() && !this.submitting;
        },

        // Pricing Methods
        calculateTotalCost() {
            // Simply return programme price minus promo code discount if applicable
            if (this.promocodeValid && this.finalPrice !== null && this.finalPrice !== undefined) {
                return parseFloat(this.finalPrice);
            }
            return parseFloat(this.programmePrice);
        },

        // Registration Type Selection
        selectRegistrationType(type) {
            this.formData.registrationType = type;
        },

        // Promo Code Validation
        async validatePromocode() {
            if (!this.formData.promocode) return;

            this.validating = true;
            this.promocodeError = '';
            
            try {
                const response = await fetch(`/api/validate-promocode`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        promocode: this.formData.promocode,
                        programmeCode: this.formData.programmeCode
                    })
                });

                const data = await response.json();

                if (data.valid) {
                    this.promocodeValid = true;
                    this.formData.promocodeId = data.promocodeId;
                    this.finalPrice = parseFloat(data.price);
                    this.discountAmount = this.programmePrice - this.finalPrice;
                } else {
                    this.promocodeError = data.message || 'Invalid promo code';
                    this.promocodeValid = false;
                }
            } catch (error) {
                this.promocodeError = 'Error validating promo code. Please try again.';
                this.promocodeValid = false;
            } finally {
                this.validating = false;
            }
        },

        // Form Submission
        async submitRegistration() {
            this.submitting = true;

            try {
                const payload = {
                    ...this.formData,
                    isGroupRegistration: this.isGroupRegistration,
                    groupMembers: this.isGroupRegistration ? this.groupMembers : [],
                    totalCost: this.calculateTotalCost()
                };

                console.log(payload);
                return;

                const response = await fetch(`/api/register-programme`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(payload)
                });

                const data = await response.json();

                if (data.success) {
                    window.location.href = data.redirectUrl;
                } else {
                    alert(data.message || 'Registration failed. Please try again.');
                }
            } catch (error) {
                alert('An error occurred. Please try again.');
            } finally {
                this.submitting = false;
            }
        }
    }));
});
