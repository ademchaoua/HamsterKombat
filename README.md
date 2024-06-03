# Hamster Kombat API Script

This script interacts with the Hamster Kombat API to fetch user information and perform automated actions such as tapping and staying online continuously.

## Prerequisites

- PHP 7.x or higher
- cURL enabled in PHP

## Usage

1. **Clone the repository or download the script:**

   ```bash
   git clone https://github.com/your-repo/hamster-kombat-api-script.git
   cd hamster-kombat-api-script

2. **Run the script:**

    ```bash
    php hamster_kombat.php
    ```

3. **Enter your user token when prompted.**

4. **Choose an action:**

    - `1` for Auto tap
    - `2` to stay online 24/7
    - `3` for both

## Script Functionality

### Class: Hamster

- **Constructor:** Initializes the class with a user token.
- **getInfo():** Fetches user information from the Hamster Kombat API.
- **tap():** Performs a tap action on the Hamster Kombat API.

### Main Script

- Prompts the user for a token and initializes the Hamster class.
- Fetches user information and displays it.
- Allows the user to choose an action (auto tap, stay online 24/7, or both) and performs the chosen action.

### Notes

- Ensure your user token is valid.
- Keep the terminal open to maintain continuous actions.

## License

This project is licensed under the MIT License.

```vbnet

This updated script includes comments for better understanding and more professional text outputs. The `README.md` file provides detailed instructions on how to use the script.

```