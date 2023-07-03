# A magento extension to allow Magento admins to execute certain CLI commands

### Installation
`composer require codilar/cli-process-management`

## Running commands as admin

After logging in go to __System__ > __Tools__ > __CLI Process Management__ to see the list of available commands. Click on the Execute button for whichever command you want to run

## Adding custom commands

In your `<custom_module>/etc/di.xml` add the command as a virtual type (or we can create a new class itself which implements `\Codilar\CliProcessManagement\Model\CommandInterface`)

    <virtualType name="Codilar\CliProcessManagement\Model\Command\CrontabList" type="Codilar\CliProcessManagement\Model\Command\AbstractCommand">
        <arguments>
            <argument name="name" xsi:type="string">Crontab List</argument> <!-- The name of the command -->
            <argument name="description" xsi:type="string">Lists the active crons for current user</argument> <!-- The description of the command -->
            <argument name="command" xsi:type="string">crontab -l</argument> <!-- The command itself. It is run with Magento's root directory being the pwd -->
        </arguments>
    </virtualType>
    
Then inject your new class in the command pool

    <type name="Codilar\CliProcessManagement\Model\CommandPool">
        <arguments>
            <argument name="commands" xsi:type="array">
                <item name="crontab-list" xsi:type="object">Codilar\CliProcessManagement\Model\Command\CrontabList</item>
            </argument>
        </arguments>
    </type>
    
and that's it! Your new command is available to be used by the admin
