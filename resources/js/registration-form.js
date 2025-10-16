// Registration Form Alpine.js Component
document.addEventListener('alpine:init', () => {
    Alpine.data('registrationForm', (config) => ({
        // State Management
        currentStep: config.user ? 2 : 1,
        totalSteps: (() => {
            // Calculate total steps (always count from step 1, even if account step is hidden)
            let steps = 3; // Base: Account, Info, Confirm (account is hidden for logged-in users)
            if (config.allowGroupRegistration) steps++; // Add Group step
            if (config.hasActivePromocodes) steps++; // Add Promo code step if active promocodes exist
            return steps;
        })(),
        allowGroupRegistration: config.allowGroupRegistration,
        hasActivePromocodes: config.hasActivePromocodes,
        groupRegistrationMin: config.groupRegistrationMin,
        groupRegistrationMax: config.groupRegistrationMax,
        groupRegIndividualFee: config.groupRegIndividualFee,
        programmePrice: config.programmePrice,
        hasActivePromotion: config.hasActivePromotion || false,
        activePromotion: config.activePromotion || null,
        formattedPrice: config.formattedPrice || '',
        discountedPrice: config.discountedPrice || null,
        
        // Form State
        validating: false,
        submitting: false,
        promocodeError: '',
        promocodeValid: false,
        discountAmount: 0,
        finalPrice: (() => {
            // Initialize finalPrice with active promotion discount if available
            if (config.hasActivePromotion && config.discountedPrice) {
                const match = config.discountedPrice.match(/[\d.]+/);
                return match ? parseFloat(match[0]) : config.programmePrice;
            }
            return config.programmePrice;
        })(),
        isGroupRegistration: false,
        groupMembers: [],
        
        // Validation Errors
        validationErrors: {},
        errorMessage: '',
        showErrors: false,
        
        // Form Data
        formData: {
            programmeCode: config.programmeCode,
            programmeId: config.programmeId,
            promocode: '',
            promocodeId: null,
            registrationType: config.user ? 'user' : 'guest',
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
            // Clear errors when moving to next step
            this.clearErrors();
            
            // Determine next step based on current configuration
            if (this.currentStep < this.totalSteps) {
                this.currentStep++;
                
                // Skip group members step if not group registration
                if (this.currentStep === 3 && this.allowGroupRegistration && !this.isGroupRegistration) {
                    this.currentStep++; // Skip to next step (promo or confirmation)
                }
                
                // Skip promo code step if no active promocodes
                if (!this.hasActivePromocodes && this.currentStep === this.getPromoCodeStepNumber()) {
                    this.currentStep++; // Skip to confirmation
                }
            }
        },

        previousStep() {
            // Clear errors when moving to previous step
            this.clearErrors();
            
            if (this.currentStep > 1) {
                this.currentStep--;
                
                // Skip promo code step if no active promocodes (going backwards)
                if (!this.hasActivePromocodes && this.currentStep === this.getPromoCodeStepNumber()) {
                    this.currentStep--; // Skip back further
                }
                
                // Skip group members step if not group registration (going backwards)
                if (this.currentStep === 3 && this.allowGroupRegistration && !this.isGroupRegistration) {
                    this.currentStep--; // Skip back to registration info
                }
            }
        },
        
        // Helper to get promo code step number
        getPromoCodeStepNumber() {
            // Promo code step is before confirmation (totalSteps - 1) if active promocodes exist
            if (!this.hasActivePromocodes) return -1; // No promo code step if no active promocodes
            return this.totalSteps - 1; // Promo code is always second to last step (before confirmation)
        },
        
        // Jump to specific step
        jumpToStep(step) {
            if (step >= 1 && step <= this.totalSteps) {
                this.currentStep = step;
                // Scroll to top of form
                this.$el.querySelector('.registration-form-container')?.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'start' 
                });
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

        // Error Handling Methods
        clearErrors() {
            this.validationErrors = {};
            this.errorMessage = '';
            this.showErrors = false;
        },
        
        hasFieldError(fieldName) {
            return this.validationErrors.hasOwnProperty(fieldName);
        },
        
        getFieldError(fieldName) {
            return this.validationErrors[fieldName] ? this.validationErrors[fieldName][0] : '';
        },
        
        determineStepForError(errors) {
            // Step 2: Registration Information (title, firstName, lastName, email, contactNumber, nric, address, city, postalCode)
            const step2Fields = ['title', 'firstName', 'lastName', 'email', 'contactNumber', 'nric', 'address', 'city', 'postalCode'];
            
            // Step 3: Group Members (if group registration is enabled)
            const step3Fields = ['groupMembers'];
            
            // Check which step has errors
            for (let field in errors) {
                if (step2Fields.includes(field)) {
                    return 2;
                }
                if (this.allowGroupRegistration && step3Fields.includes(field)) {
                    return 3;
                }
            }
            
            // Default to current step
            return this.currentStep;
        },
        
        displayValidationErrors(errors, message = '') {
            this.validationErrors = errors;
            this.errorMessage = message || 'Please correct the errors below.';
            this.showErrors = true;
            
            // Determine which step has the error and jump to it
            const errorStep = this.determineStepForError(errors);
            this.jumpToStep(errorStep);
            
            // Scroll to error message
            setTimeout(() => {
                this.$el.querySelector('.error-alert')?.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'center' 
                });
            }, 100);
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
        parsePrice(priceString) {
            // Parse price string like "SGD 50.00" or "Free" to number
            if (!priceString || priceString === 'Free') return 0;
            const match = priceString.match(/[\d.]+/);
            return match ? parseFloat(match[0]) : 0;
        },

        getEffectivePrice() {
            // Return the effective price (promotion price if active, otherwise original price)
            if (this.hasActivePromotion && this.discountedPrice) {
                return this.parsePrice(this.discountedPrice);
            }
            return parseFloat(this.programmePrice);
        },

        calculateTotalCost() {
            // Return effective price (promotion price if active) minus promo code discount if applicable
            if (this.promocodeValid && this.finalPrice !== null && this.finalPrice !== undefined) {
                return parseFloat(this.finalPrice);
            }
            return this.getEffectivePrice();
        },

        // Registration Type Selection
        selectRegistrationType(type) {
            this.formData.registrationType = type;
        },

        // Promo Code Validation
        async validatePromocode() {
            // Skip promo code validation if no active promocodes
            if (!this.hasActivePromocodes) return;
            
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
                    // Calculate discount from effective price (promotion price if active)
                    const effectivePrice = this.getEffectivePrice();
                    this.discountAmount = effectivePrice - this.finalPrice;
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
            // Clear any previous errors
            this.clearErrors();
            this.submitting = true;

            try {
                const payload = {
                    ...this.formData,
                    isGroupRegistration: this.isGroupRegistration,
                    groupMembers: this.isGroupRegistration ? this.groupMembers : [],
                    totalCost: this.calculateTotalCost()
                };

                const response = await fetch(`/api/register-programme`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(payload)
                });

                // Check if response is JSON
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    const responseText = await response.text();
                    console.error('Non-JSON response received:', responseText);
                    this.errorMessage = `Server error (${response.status}). The server returned an unexpected response. Please try again or contact support.`;
                    this.showErrors = true;
                    return;
                }

                const data = await response.json();
                
                console.log('Response data:', data);
                console.log('Response status:', response.status);

                // Handle validation errors (422 status)
                if (response.status === 422) {
                    if (data.errors) {
                        this.displayValidationErrors(data.errors, data.message || 'Validation failed. Please check the form.');
                    } else {
                        this.errorMessage = data.message || 'Validation failed. Please check your inputs.';
                        this.showErrors = true;
                    }
                    return;
                }

                // Handle success
                if (response.ok && data.success) {
                    window.location.href = data.redirectUrl;
                    return;
                }

                // Handle other errors
                if (!response.ok) {
                    this.errorMessage = data.message || `Server error (${response.status}). Please try again.`;
                    this.showErrors = true;
                    return;
                }

                // Handle API error response
                if (!data.success) {
                    this.errorMessage = data.message || 'Registration failed. Please try again.';
                    this.showErrors = true;
                }

            } catch (error) {
                console.error('Registration error:', error);
                
                // Check if it's a JSON parsing error
                if (error instanceof SyntaxError && error.message.includes('JSON')) {
                    this.errorMessage = 'Server error: The server returned an invalid response. Please check the browser console for details or contact support.';
                } else {
                    this.errorMessage = 'An unexpected error occurred. Please try again.';
                }
                
                this.showErrors = true;
            } finally {
                this.submitting = false;
            }
        }
    }));
});
