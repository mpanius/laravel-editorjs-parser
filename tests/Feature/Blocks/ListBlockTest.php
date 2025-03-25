<?php

namespace Ixbtcom\LaravelEditorJsParser\Tests\Feature\Blocks;

use Ixbtcom\LaravelEditorJsParser\Tests\TestCase;

class ListBlockTest extends TestCase
{
    protected function getBlockData()
    {
        return [
            'type' => 'list',
            'data' => [
                'style' => 'unordered',
                'items' => [
                    'Hello',
                    'World',
                ],
            ],
        ];
    }

    protected function getBlockHtml()
    {
        return "<ul>        <li>Hello</li>        <li>World</li>    </ul>";
    }

    /** @test */
    public function render_paragraph_block_test(): void
    {
        $this->assertEquals(
            $this->renderBlocks($this->getEditorData([$this->getBlockData()])),
            $this->getBlockHtml()
        );
    }
}
